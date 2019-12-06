<?php 
    use MiladRahimi\PhpRouter\Router;
    use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
    use App\Middlewares\UserAuthenticate;

    $router = new Router('', 'App\Controllers\Api\V1');

    $router->group(['prefix' => '/api/v1'], function (Router $router) {
        // open apis

        $router->group(['middleware' => UserAuthenticate::class], function (Router $router) {
            // authenticated apis
        });
    });

    try {
        $router->dispatch();
    } catch (RouteNotFoundException $th) {
        //throw $th;
    }