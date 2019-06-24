<?php namespace App;

use App\User;

class UserService {
    public function findById($id) : User {
        return new User($id, "Marcelo", 45);
    }
}
?>