<?php 
    use MiladRahimi\PhpRouter\Router;
    use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
    
    $router = new Router('', 'App\Controllers');

    $router->get("/", "Index@index");

    try {
        $router->dispatch();
    }catch(RouteNotFoundException $e){
    }