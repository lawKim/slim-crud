<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as SlimResponse;
use Throwable;

class PagesController{
    // Set the Homepage Content
    public function home(Request $request, Response $response, $args): Response {
        $response->getBody()->write("Hello world!");
        return $response;
    }

    // Set the Custom Test Page
    public function test(Request $request, Response $response, $args): Response {
        $response->getBody()->write("Hello worldd!");
    
        return $response;
    } 
    // Not Found Section
    public function notfound(Request $request, Throwable $exception,bool $displayErrorDetails): Response {
        $response = new SlimResponse(); 
        $response->getBody()->write('PAGE NOT FOUND');
        return $response->withStatus(404);
    } 

    // Not Allowed Section
    public function notallowed(Request $request, Throwable $exception,bool $displayErrorDetails): Response {
        $response = new SlimResponse();
       ob_start();
        var_dump($exception);
        $response->getBody()->write(ob_get_clean());
        return $response->withStatus(405);
    } 
}