<?php
declare(strict_types=1);

namespace App\Application\Middleware;

// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Psr7\Response;


class Layer2 implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $finalResponse = new Response();
        
        // $finalResponse->getBody()->write('LAYER 2 IN + ');

        // $response = $handler->handle($request); //manipula a rota

        // $existingContent = ((string) $response->getBody());

        // $finalResponse->getBody()->write($existingContent . "+ LAYER 2 OUT + ");

        return $finalResponse;
    }
}
