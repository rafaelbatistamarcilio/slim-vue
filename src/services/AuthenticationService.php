<?php namespace App;
use \Firebase\JWT\JWT;
use \Firebase\JWT\UnexpectedValueException;

class AuthenticationService {

    public static $AUTH_KEY  = '6lsdf345345efmnjds98374892aklshdlkashdkjsah734987hvfiuonafl';
    public static $ENCRIPT_ALG = 'HS512';

    public function getUserInfo($user, $password) {
        if ($this->isValidCredentias($user, $password)) {
            $token = $this->getUserToken($user);
            $encriptet = $this->encriptToken($token);
            return new UserInfoVo( $user , $token['data']['roles'] , $encriptet);
        } 
        return null;
    }

    public function isValidCredentias($user, $password) {
        // call repository
        if ( ($user == 'admin' && $user == 'admin' ) || ($user == 'user' && $password == 'user')) {
            return true;
        }
        return false;
    }

    public function getUserToken($user) {
        //call repository to get user roles
        $roles = $user == 'admin' ? ['USER_W'] :['USER_R'];
        $token = $this->generateToken();
        $userInfo = [
            'username' => $user,
            'roles' => $roles
        ];
        $token['data'] = $userInfo;
        return $token;
    }

    public function generateToken() {
        $token = array(
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => time(),
            "exp" => $this->getExpirationTime(),
            "data" => null
        );
        return $token;
    }

    public function getExpirationTime() {
        $now = time();
        $end = $now + (30 * 60);
        return $end;
    }

    public function encriptToken($token) {
        $jwt = JWT::encode($token, AuthenticationService::$AUTH_KEY , AuthenticationService::$ENCRIPT_ALG);
        return $jwt;
    }

    public static function decriptToken($token): object {
        $decoded = JWT::decode($token, AuthenticationService::$AUTH_KEY , array(AuthenticationService::$ENCRIPT_ALG));
        return $decoded;
    }
}
