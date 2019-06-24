<?php namespace App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpForbiddenException;

class AuthorizationMiddleware implements MiddlewareInterface {

    public $roles;

    public function __construct($roles) {
        $this->roles = $roles;
    }

    public function process(Request $request, RequestHandler $handler): Response {
        $this->validateAuthorization($request);
        return $handler->handle($request);
    }

    public function validateAuthorization(Request $request) {
        if ($this->roles != null) {
            $token = str_replace('Bearer ', '', $request->getHeader('Authorization'))[0];
            $decripted = AuthenticationService::decriptToken($token);
            $userRoles = $decripted->data->roles;
            foreach ($this->roles as $requiredRole) {
                if (!$this->hasRole($requiredRole, $userRoles)) {
                    throw new  HttpForbiddenException($request, 'Unauthorized Operation');
                }
            }
        }
    }

    public function hasRole($requiredRole, $userRoles) {
        foreach ($userRoles as $role) {
            if ($requiredRole == $role) {
                return true;
            }
        }
        return false;
    }
}