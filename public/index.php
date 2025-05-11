<?php
use Slim\Factory\AppFactory;

use Slim\Middleware\MethodOverrideMiddleware; 
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpMethodNotAllowedException;   
use App\Controllers\PagesController;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Config/database.php'; // Eloquent bootstrapping 
// Run the migration
/*
try {
    require __DIR__ . '/../src/Migrations/CreateUsersTable.php';
    $migration = new CreateUsersTable();
    $migration->up();
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
*/ 

$app = AppFactory::create();

// Add these middlewares IN ORDER: 
$app->add(new MethodOverrideMiddleware()); // Then detect method override
$app->addRoutingMiddleware();              // Finally, handle routing

$app->setBasePath('/slim');

// Load routes
(require __DIR__ . '/../src/Router/user.php')($app);
(require __DIR__ . '/../src/Router/pages.php')($app);

// Error handling middleware

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, PagesController::class . ':notfound'); 
//$errorMiddleware->setErrorHandler(HttpMethodNotAllowedException::class, PagesController::class . ':notallowed');   

$app->run();