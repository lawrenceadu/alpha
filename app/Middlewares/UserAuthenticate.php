<?php
    namespace App\Middlewares;

    use MiladRahimi\PhpRouter\Router;
    use MiladRahimi\PhpRouter\Middleware;
    use Psr\Http\Message\ServerRequestInterface;
    use Zend\Diactoros\Response\JsonResponse;
    
    class UserAuthenticate implements Middleware
    {
        public function handle(ServerRequestInterface $request, \Closure $next)
        {
            if ($request->getHeader('Authorization')) {
                return $next($request);
            }
    
            return $this->unauthorized();
        }

        public function unauthorized()
        {
            return new JsonResponse(['success' => false, 'code' => 401, 'data' => ['error' => 'Unauthorized']], 401);
        }
    }