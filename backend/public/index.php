<?php

use Zend\Stratigility\MiddlewarePipe;
use Zend\Diactoros\Server;
use Blog\Service\Post;

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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $post->find($id);
    } else {
        $result = $post->findAll();
    }

    if (isset($_GET['resume']) && $_GET['resume'] == 1) {
        $result = $post->getOnlyResumeOfContent($result);
    }


    if (preg_match('/md$/', $req->getUri()->getPath())) {

        $parsedown = new Parsedown;
        $textToMarkdown = function ($data) use ($parsedown, &$textToMarkdown) {
            if (is_array($data)) {
                foreach ($data as $key => $entry) {
                    if ($key == 'conteudo')
                        $result[$key] = $textToMarkdown($entry);
                    else
                        $result[$key] = $entry;
                }

                return $result;
            }

            return $parsedown->text($data);
        };

        $result = $textToMarkdown($result);
    }

    $result = json_encode($result, true);
    return $res->end($result);
});

$server->listen();
