<?php namespace App;
use App\Model;

class AuthToken extends Model {

    private $username;
    private $expiration;
    private $roles;

    public function __construct() {

    }

    public function encript() {

    }

    public static function decript($tokenString) {

    }

    public static function validate($toke) {
        $part = explode(".",$token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload",'minha-senha',true);
        $valid = base64_encode($valid);

        if($signature == $valid){
        echo "valid";
        }else{
        echo 'invalid';
        }
    }
}
