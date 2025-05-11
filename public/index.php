<?php

declare(strict_types=1);

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

// Reference: https://www.slimframework.com/docs/v4/middleware/method-overriding.html
// Add RoutingMiddleware before we add the MethodOverrideMiddleware so the method is overridden before routing is done
$app->addRoutingMiddleware();
// Add MethodOverride middleware
$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware);

$app->setBasePath('/slim');

// Load routes
(require __DIR__ . '/../src/Router/user.php')($app);
(require __DIR__ . '/../src/Router/pages.php')($app);

// Error handling middleware

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, PagesController::class . ':notfound'); 
//$errorMiddleware->setErrorHandler(HttpMethodNotAllowedException::class, PagesController::class . ':notallowed');   

$app->run();