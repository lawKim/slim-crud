<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Slim\Middleware\MethodOverrideMiddleware; 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public function index(Request $request, Response $response): Response
    {
        $users = User::all();
        $formResponse = $request->getQueryParams()['formResponse'] ?? null;
        
        ob_start();
        include __DIR__ . '/../Views/users/index.php';
        $response->getBody()->write(ob_get_clean());
        return $response;
    } 

    public function create(Request $request, Response $response): Response
    {
        // Get the error from query parameters (e.g., ?error=invalid_input)
        $formResponse = $request->getQueryParams()['formResponse'] ?? null;

        // Capture the view output
        ob_start();
        include __DIR__ . '/../Views/users/create.php';
        $output = ob_get_clean();
        
        // Write to response body
        $response->getBody()->write($output);
        return $response;
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
 
        // Validation
        if (empty($data['name']) || empty($data['email'])) { 
            return $response
                ->withHeader('Location', '/slim/users/create?formResponse=invalid_input')
                ->withStatus(303);
        }

        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email']
            ]);
        } catch (\Exception $e) {
            // Log the error here
            return $response
                ->withHeader('Location', '/slim/users/create?formResponse=database_error')
                ->withStatus(303);
        }

        return $response
            ->withHeader('Location', '/slim/users')
            ->withStatus(303);
    }
    
    public function edit(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $user = User::find($id);
        $formResponse = $request->getQueryParams()['formResponse'] ?? null;

        if (!$user) {
            return $response
                ->withHeader('Location', '/slim/users?formResponse=user_not_found')
                ->withStatus(303);
        }

        ob_start();
        include __DIR__ . '/../Views/users/edit.php';
        $response->getBody()->write(ob_get_clean());
        return $response;
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = $args['id']; 
        // Manually parse multipart/form-data for PUT
        $data = $request->getParsedBody(); 

        // If parsedBody is empty, parse manually
        if (empty($data)) {
            $body = $request->getBody()->getContents();
            parse_str($body, $data);
        }

        // Validation
        if (empty($data['name']) || empty($data['email'])) {
            return $response
                ->withHeader('Location', "/slim/users/$id/edit?formResponse=invalid_input")
                ->withStatus(303);
        }

        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email']
            ]);
        } catch (\Exception $e) {
            return $response
                ->withHeader('Location', "/slim/users/$id/edit?formResponse=update_failed")
                ->withStatus(303);
        }

        return $response
            ->withHeader('Location', "/slim/users/$id/edit?formResponse=update_success")
            ->withStatus(303);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {  
        $id = $args['id'];

        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Exception $e) {
            return $response
                ->withHeader('Location', "/slim/users?error=delete_failed")
                ->withStatus(303);
        }

        return $response
            ->withHeader('Location', '/slim/users')
            ->withStatus(303);
    }
}
