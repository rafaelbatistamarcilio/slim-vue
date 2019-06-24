<?php namespace App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StaticContentLoader {
    public function __invoke(Request $request, Response $response, $args) {
        $uri = $request->getUri();
        $asset = '.'.$uri->getPath();
        if (file_exists($asset)) {
            $response->getBody()->write(file_get_contents($asset));
        }
        $contentType = $this->getContentType($uri->getPath());
        return $response->withHeader('Content-type', $contentType);
    }

    public function getContentType($path) {
        $type =  explode('.', $path);
        $type = $type[sizeof($type)-1];
        switch ($type) {
            case 'js':
                return 'application/javascript';
                break;
            case 'html':
                return 'text/html';
                break;
            default:
                return 'text/css';
                break;
        }
    }
}