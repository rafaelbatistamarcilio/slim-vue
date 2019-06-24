<?php namespace App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class WebContentLoader {
    public function __invoke(Request $request, Response $response, $args) {
        // $view = $args && $args['view'] != null && $args['view'] != '' ? $args['view'] : 'index';
        // $file = './views/'.$view.'.html';
        // $file = file_exists($file) ? $file : './views/404.html';
        $file = './public/index.html';
        $response->getBody()->write(file_get_contents($file));
        return $response;
    }
}