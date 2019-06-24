<?php namespace App;
  use App\UserService;

class ApplicationContex {
    
    public static function load($container) {
        $container->set('UserService', function () {
            return new UserService();
        });
    }
}
