<?php namespace App;

use App\AuthenticationController;
use App\UserController;

class Routes {
    static function get() {
        return [
            '/auth'=> [
                'controller'=> AuthenticationController::class,
                'needAuth' => false
            ],
            '/user'=> [
                'controller'=> UserController::class,
                'needAuth' => true
            ]
        ];
    }
}
?>