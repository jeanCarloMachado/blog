<?php

use Zend\Stratigility\MiddlewarePipe;
use Zend\Diactoros\Server;
use Blog\Service\Post;
use Blog\Service\Metadata;
use Blog\Service\Feed as BlogFeed;

date_default_timezone_set('America/Sao_Paulo');

require __DIR__.'/../vendor/autoload.php';

$files = glob('../config/{global,local}*.php', GLOB_BRACE);
$config = Zend\Config\Factory::fromFiles($files);

$app = new MiddlewarePipe();
$server = Server::createServer(
    $app,
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$adapter = new Zend\Db\Adapter\Adapter($config['database']);

$app->pipe('/', function ($req, $res, $next) {
    if ($req->getUri()->getPath() !== '/') {
        return $next($req, $res);
    }

    return $res->end('My blog is currently at jeancarlomachado.com.br');
});

$app->pipe('/posts', function ($req, $res, $next) use ($adapter) {
    $post = new Post($adapter);
    $result = $post->findAll($_GET);
    $parsedown = new Parsedown();
    $parsedown->setMarkupEscaped(true);
    foreach($result as $key => $value) {
        $result[$key]['conteudo'] = $parsedown->text(preg_replace('/#/','',$value['conteudo']));
    }

    $result = json_encode($result, true);

    return $res->end($result);
});

$app->pipe('/post', function ($req, $res, $next) use ($adapter) {

    $id = substr($req->getUri()->getPath(), 1);

    if (!(string) (int) $id == $id) {
        throw new Exception('You must pass an id');
    }

    $post = new Post($adapter);
    $result = $post->find($id);

    $parsedown = new Parsedown();
    $parsedown->setMarkupEscaped(true);

    if (!isset($result[0]['conteudo'])) {
        $result[0]['conteudo'] = '';
    }
    $result[0]['conteudo'] = $parsedown->text($result[0]['conteudo']);
    $result = json_encode($result, true);

    return $res->end($result);
});

$app->pipe('/root/posts', function ($req, $res, $next) use ($adapter) {
    $post = new Post($adapter);
    $post->setRoot(true);
    $result = $post->findAll($_GET);
    $result = json_encode($result, true);

    return $res->end($result);
});

$app->pipe('/root/post', function ($req, $res, $next) use ($adapter) {
    $id = substr($req->getUri()->getPath(), 1);

    if (!(string) (int) $id == $id) {
        throw new Exception('You must pass an id');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        parse_str(file_get_contents('php://input'), $data);

        if (!isset($data['titulo'])) {
            $data['titulo'] = $data['metatag']['title'];
        }

        $post = new Post($adapter);
        $post->setRoot(true);
        $postId = $post->create($data);

        $meta = new Metadata($adapter);
        $data = $data['metatag'];
        $data['related_id'] = $postId;
        $meta->create($data);

        (new BlogFeed())->removeCache();

        return $res->end($postId);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        parse_str(file_get_contents('php://input'), $data);
        $post = new Post($adapter);
        $post->setRoot(true);
        $post->update($id, $data);

        $meta = new Metadata($adapter);
        foreach ($data as $column => $value) {
            if (array_key_exists($column, $meta->getColumns())) {
                $postEntity = $post->find($id);
                $postEntity = reset($postEntity);
                $meta->update($postEntity['related_id'], $data);
                break;
            }
        }

        (new BlogFeed())->removeCache();

        return $res->end();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!(string) (int) $id == $id) {
            throw new Exception('You must pass an id');
        }

        $post = new Post($adapter);
        $result = $post->find($id);
        $result = json_encode($result, true);

        return $res->end($result);
    }

    throw new \Exception('Cannot find an proper action');
});

$app->pipe('/feed', function ($req, $res, $next) use ($adapter) {

    $feed = new BlogFeed();
    if ($feed->hasCache()) {
        return $res->end($feed->getCache());
    }

    $post = new Post($adapter);
    $result = $post->findAll($_GET);

    $feedContent = $feed->create($result);

    return $res->end($feedContent);
});

$server->listen();
