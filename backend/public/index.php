<?php

use Zend\Stratigility\MiddlewarePipe;
use Zend\Diactoros\Server;
use Blog\Service\Post;
use Blog\Service\Markdown;

require __DIR__.'/../vendor/autoload.php';

$files = glob('../config/{global,local}*.php', GLOB_BRACE);
$config = Zend\Config\Factory::fromFiles($files);

$app = new MiddlewarePipe();
$server = Server::createServer($app, $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

$adapter = new Zend\Db\Adapter\Adapter($config['database']);

$app->pipe('/', function ($req, $res, $next) {
    if ($req->getUri()->getPath() !== '/') {
        return $next($req, $res);
    }

    return $res->end('My blog is currently at jeancarlomachado.com.br');
});

$app->pipe('/posts', function ($req, $res, $next) use ($adapter) {
    $post = new Post($adapter);

    if (isset($_GET['firstResult'])) {
        $result = $post->findAll(
            $_GET['firstResult'],
            $_GET['maxResults']
        );
    } else {
        $result = $post->findAll();
    }

    if (isset($_GET['resume']) && $_GET['resume'] == 1) {
        $result = $post->getOnlyResumeOfContent($result);
    }

    $result = json_encode($result, true);
    return $res->end($result);
});

$app->pipe('/post', function ($req, $res, $next) use ($adapter) {
    $post = new Post($adapter);

    if (!isset($_GET['id'])) {
        throw new \Exception('You must passa a filter');
    }

    $id = $_GET['id'];
    $result = $post->find($id);

    if (preg_match('/md$/', $req->getUri()->getPath())) {
        $markdown = new Markdown(new Parsedown, $result);
        $result = $markdown->convert();
    }

    $result = json_encode($result, true);
    return $res->end($result);
});

$server->listen();
