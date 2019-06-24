<?php namespace App;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Routing\RouteCollectorProxy;
    use App\UserService;
    use App\AuthorizationMiddleware;

class UserController {

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function __invoke($group) {
        $group->get('/{id}', UserController::class.':findById')
            ->add(new AuthorizationMiddleware(array('USER_RW')));
            $group->get('', UserController::class.':findAll');
    }

    public function findAll(Request $request, Response $response) {
        $response->getBody()->write(array('a'));
        return $response;
    }

    public function findById(Request $request, Response $response, $params) {
        $user = $this->userService->findById($params['id']);
        $response->getBody()->write($user->json());
        return $response->withHeader('Content-Type', 'application/json');
    }
}