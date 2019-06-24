<?php namespace App;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Routing\RouteCollectorProxy;
    use App\UserService;
    use App\AuthorizationMiddleware;
    use Fig\Http\Message\StatusCodeInterface;

class UserController {

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function __invoke($group) {
        $group->get('/{id}', UserController::class.':findById')
            ->add(new AuthorizationMiddleware(array('USER_R')));
            $group->delete('/{id}', UserController::class.':delete')
            ->add(new AuthorizationMiddleware(array('USER_W')));
    }

    public function findById(Request $request, Response $response, $params) {
        $user = $this->userService->findById($params['id']);
        $response->getBody()->write($user->json());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, $params) {
        $response->getBody()->write(json_encode((object) ['message' => [ $params['id'] ] ]));
        return $response->withStatus(StatusCodeInterface::STATUS_ACCEPTED);
    }
}