<?php

use App\Controllers\PagesController;
 
return function($app) {   
    // Set the Homepage Content
    $app->get('/', PagesController::class . ':home')->setName('home');
    $app->get('/test', PagesController::class . ':test')->setName('test');
};