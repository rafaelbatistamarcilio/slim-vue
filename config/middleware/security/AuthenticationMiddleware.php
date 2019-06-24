<?php namespace App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;

class AuthenticationMiddleware implements MiddlewareInterface {

    public function process(Request $request, RequestHandler $handler): Response {
        try {
            $this->validateHeader($request);
            $this->validateToken($request);
            return $handler->handle($request);
        } catch (ExpiredException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        } catch (BeforeValidException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        } catch (SignatureInvalidException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        }
    }

    private function validateHeader(Request $request) {
        $auth = $request->getHeaderLine('Authorization');
        if ($auth == null){
            throw new HttpUnauthorizedException($request, 'User not authenticated');
        }

        $token = trim(str_replace('Bearer', '', $auth));
        if ($token == null || $token == '') {
            throw new HttpUnauthorizedException($request, 'User not authenticated');
        }
    }

    private function validateToken(Request $request) {
        $token = str_replace('Bearer ', '', $request->getHeader('Authorization'))[0];
        AuthenticationService::decriptToken($token);
    }
}