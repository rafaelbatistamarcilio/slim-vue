<?php namespace App;
    use Slim\Psr7\Response as Resp;
    use Fig\Http\Message\StatusCodeInterface;

    class UnauthorizedHandler {
        public function __invoke($request, $exception, $displayErrorDetails, $logErrors, $logErrorDetails) {
            $response = new Resp(StatusCodeInterface::STATUS_UNAUTHORIZED);
            $response->withHeader('Content-type', 'application/json');
            $payload = (object)['message'=> $exception->getMessage()];
            $response->getBody()->write(json_encode($payload));
            return $response;
        }
    }