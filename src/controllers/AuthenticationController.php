<?php namespace App;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use App\UserInfoVo;
    use App\AuthenticationService;
    use Fig\Http\Message\StatusCodeInterface;

class AuthenticationController {
    private $authService;

    public function __construct() {
        $this->authService = new AuthenticationService();
    }

    public function __invoke($group) {
        $group->post('/login', AuthenticationController::class.':login');
        $group->post('/decript', AuthenticationController::class.':decriptToken');
    }

    public function login(Request $request, Response $response) {
        $userInfo = $this->getUserInfo($request);
        if ($userInfo) {
            $response->getBody()->write($userInfo->json());
        } else {
            $response->getBody()->write(json_encode(['message'=> 'invalid credentials'])); 
            $response = $response->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }
        return  $response->withHeader('Content-Type', 'application/json');
    }

    public function getUserInfo($request) {
        $body = $request->getParsedBody();
        $user = $body['user'];
        $password = $body['password'];
        return $this->authService->getUserInfo($user, $password);
    }

    public function decriptToken(Request $request, Response $response) {
        $body = $request->getParsedBody();
        $decripted = AuthenticationService::decriptToken($body['token']);
        $decripted->iat = date("d/m/Y\TH:i:s\Z", $decripted->iat);
        $decripted->exp = date("d/m/Y\TH:i:s\Z", $decripted->exp);
        $response->getBody()->write(json_encode(['token'=> $decripted]));
        return $response;
    }
}
