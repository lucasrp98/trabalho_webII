<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\Cliente\ListClientesAction;
use App\Application\Actions\Cliente\ViewClienteAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/cidadao', function (Request $request, Response $response) {
        $con = $this->get('db');
        $result = mysqli_query($con, "Select * from cidadao");
        
        $users = [];
        while ($row = mysqli_fetch_array($result)) {
            $user = array(
                // "customerid" => $row['customerid'],
                "id" => $row['id'],
                "nome" => $row['nome']
            );
            $users[] = $user;
        }
        $users = array("users" => $users);
        $json = json_encode($users);
        $response->getBody()->write($json);
        return $response;
    });

    $app->post('/cidadao', function (Request $request, Response $response) {
        $jsonData = json_decode($request->getBody()->__toString(), true);
        $id = $jsonData['id'];
        $nome = $jsonData['nome'];
        // echo $nome;
        $data = [
            // 'id' => $id,
            'nome' => $nome
        ];
        $response->getBody()->write(json_encode($data));
        $con = $this->get('db');
        
        $result = mysqli_query($con, "INSERT INTO cidadao (nome) VALUES ('@$nome')");
        
        return $response;
    });
    $app->delete('/cidadao/{id}', function (Request $request, Response $response, array $args) {
        $con = $this->get('db');
        // $pdo = $this->get('bd');
        // $result = mysqli_query("SELECT * FROM cidadao WHERE id = " . $args['id']);
         $result = $con->prepare("SELECT * FROM cidadao WHERE id = " . $args['id']);
        // $result->execute();

        while ($row = mysqli_fetch_array($result)) {
            if ($row) {
            $result = $con->prepare("DELETE FROM cidadao WHERE id = " . $args['id']);
            $result->execute();
            $user = array(
                "id" => $args['id'],
                "status" => 'cidadao excluido',
            );
        }
        else {
            $user = array(
                "id" => $args['id'],
                "status" => 'usuario nao encontrado para deletar',
            );
        }
        }        
        
        $json = json_encode($user);
        

        //Apliquei tipo de dados
        $novoResponse = $response->withHeader('Content-type', 'application/json');
        $novoResponse->getBody()->write($json);
        return $novoResponse;
    });
  
};
