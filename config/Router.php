<?php namespace App;

use Slim\Routing\RouteCollectorProxy;
use App\Routes;
use App\AuthenticationMiddleware;

use App\AuthenticationController;
use App\UserController;
class Router {
    public function __invoke(RouteCollectorProxy $api) {

        $routes = Routes::get();
        foreach ($routes as $route => $config) {
            
            if ($config['needAuth']) {
                $api->group($route, $config['controller'])->add(new AuthenticationMiddleware());
            }else {
                $api->group($route, $config['controller']);
            }
        }
        // $api->group('/auth', AuthenticationController::class);
        //         $api->group('/user', UserController::class)->add(new AuthenticationMiddleware());
    }
}