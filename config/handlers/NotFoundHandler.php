<?php namespace App;
    use Slim\Psr7\Response as NotFoundResponse;
    use Fig\Http\Message\StatusCodeInterface;

    class NotFoundHandler {
        public function __invoke($request, $exception, $displayErrorDetails, $logErrors, $logErrorDetails) {
            $response = new NotFoundResponse(StatusCodeInterface::STATUS_NOT_FOUND);
            if (strpos($request->getUri()->getPath(), 'api' )) {
                $response->withHeader('Content-type', 'application/json');
                $payload = (object) ['message'=> 'not found'];
                $response->getBody()->write(json_encode($payload));
            } else {
                $response->getBody()->write(file_get_contents('./views/404.html'));
            }
            return $response;
        }
    }