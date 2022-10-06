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

    // get mysql
    // $app->get('/cidadao', function (Request $request, Response $response) {
    //     $con = $this->get('db');
    //     $result = mysqli_query($con, "Select * from cidadao");

    //     $users = [];
    //     while ($row = mysqli_fetch_array($result)) {
    //         $user = array(
    //             // "customerid" => $row['customerid'],
    //             "id" => $row['id'],
    //             "nome" => $row['nome']
    //         );
    //         $users[] = $user;
    //     }
    //     $users = array("users" => $users);
    //     $json = json_encode($users);
    //     $response->getBody()->write($json);
    //     return $response;
    // });

    //get PDO

    $app->get(
        '/cidadao',
        function (Request $request, Response $response, array $args) {
            $user = ' ';
            $pdo = $this->get('db');
            $result = $pdo->prepare("Select * from cidadao");
            $result->execute();

            $row = $result->fetch(PDO::FETCH_ASSOC);
            // monta o Json
            if ($row) {
                $user = array(
                    "id" => $row['id'],
                    "nome" => $row['nome'],

                );
            }
            $json = json_encode($user);

            //Apliquei tipo de dados
            $novoResponse = $response->withHeader('Content-type', 'application/json');
            $novoResponse->getBody()->write($json);
            return $novoResponse;
        }
    );


    // POST JSON
    $app->post('/cidadao/json', function (Request $request, Response $response) {
        $jsonData = json_decode($request->getBody()->__toString(), true);
        // $id = $jsonData['id'];
        $nome = $jsonData['nome'];
        // echo $nome;
        $data = [
            // 'id' => $id,
            'nome' => $nome
        ];
        $response->getBody()->write(json_encode($data));

        $pdo = $this->get('db');
        $result = $pdo->prepare("INSERT INTO public.cidadao(nome)VALUES (:nome)");
        $result->bindParam(':nome', $nome, PDO::PARAM_STR);
        $status = $result->execute();

        return $response;
    });


    // POST PDO

    $app->post('/cidadao', function (Request $request, Response $response) {
        $body = "ok";
        //Pega os argumentos enviados pelo formulario- "form/data"
        //Cast para tipo ARRAY
        $inputForm = (array)$request->getParsedBody();


        //Verifica se os campos estão presentes
        $nome = isset($inputForm['nome']) ? $inputForm['nome'] : "";

        if ($nome != "") {

            $pdo = $this->get('db');
            $result = $pdo->prepare("INSERT INTO public.cidadao(nome)VALUES (:nome)");
            $result->bindParam(':nome', $nome, PDO::PARAM_STR);
            $status = $result->execute();

            // $id = $pdo->lastInsertId();



            //Listar após inserir
            // $result = $pdo->prepare("SELECT * FROM cidadao WHERE id = 1");
            // id");
            // $result->bindParam(':id', $id, PDO::PARAM_STR);
            // $result->execute();

            // $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($status) {
                //Imprime o resultado usuario criado
                $body = "Usuário criado!\n";
                $body .= "Nome: " . $nome . "\n";
            } else {
                $body = "Erro ao criar o usuário\n";
            }
            //ESCREVE NO CORPO E RETORNA
            $response->getBody()->write($body);

            return $response->withStatus(201);
        } else {
            $body = 'Sem o campo "NOME" ou valores vazios" ';
            //ESCREVE NO CORPO E RETORNA
            $response->getBody()->write($body);

            return $response->withStatus(500);
        };
    });

    //Deletar o cidadao 

    $app->delete('/cidadao/{id}', function (Request $request, Response $response, array $args) {
        $pdo = $this->get('db');
        $result = $pdo->prepare("SELECT * FROM cidadao WHERE id = " . $args['id']);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if (($row)) {
            $result = $pdo->prepare("DELETE FROM cidadao WHERE id = " . $args['id']);
            $result->execute();
            $user = array(
                "id" => $args['id'],
                "nome" => $row["nome"],
                "status" => 'usuario excluido',
            );
        } else {
            $user = array(
                "id" => $args['id'],
                "status" => 'usuario nao encontrado para deletar',
            );
        }
        $json = json_encode($user);


        //Apliquei tipo de dados
        $novoResponse = $response->withHeader('Content-type', 'application/json');
        $novoResponse->getBody()->write($json);
        return $novoResponse;
    });

    //Atualizar o cidadao

    $app->put('/cidadao/{id}', function (Request $request, Response $response, array $args) {

        $inputForm = (array)$request->getParsedBody();
        $id = $args["id"];
        // $id= isset($inputForm['id'])?$inputForm['id']:"";
        $nome = isset($inputForm['nome']) ? $inputForm['nome'] : "";

        $body = "";
        //     $pdo = $this->get('db');    
        //     $result = $pdo->prepare("SELECT * FROM cidadao ORDER BY nome");
        //     $result->execute();

        // while($row = $result->fetch(PDO::FETCH_ASSOC)){

        // $body .= "ID: ". $row['id']."\n";
        // $body .= "Nome: ". $row['nome']."\n";

        $pdo = $this->get('db');
        $result = $pdo->prepare("UPDATE cidadao SET nome= :nome WHERE id= :id ");
        $result->bindParam(':id', $id);
        $result->bindParam(':nome', $nome, PDO::PARAM_STR);
        $status = $result->execute();

        if ($status) {


            // $result = $pdo->prepare("SELECT * FROM cidadao WHERE id = :id");
            // $result->bindParam(':id', $id, PDO::PARAM_STR);
            // $result->execute();

            // $row = $result->fetch(PDO::FETCH_ASSOC);

            $body = "Atualização do Cidadao!\n";
            $body .= "ID: $id\n";
            $body .= "Nome: " . $nome . "\n";

            $response->getBody()->write($body);

            return $response->withStatus(201);
        } else {
            $body .= 'Sem o campo "ID" ou valor vazio" ';
            $response->getBody()->write($body);
            return $response->withStatus(500);
        };
        // }
    });
};
