<?php namespace App;
use App\Model;

class UserInfoVo extends Model {

    public $username;
    public $roles;
    public $token;

    public function __construct($username, $roles, $token) {
        $this->username = $username;
        $this->roles = $roles;
        $this->token = $token;
    }
    
}