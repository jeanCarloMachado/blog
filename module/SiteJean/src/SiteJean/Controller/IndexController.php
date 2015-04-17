<?php
namespace SiteJean\Controller;

use AckMvc\Controller\Base;
use Zend\Feed\Writer\Feed;

class IndexController extends Base
{
    const POSTS_PER_PAGE = 4;
    private $currentPage = 0;

    public function feedAction()
    {
        $postsService = $this->getServiceLocator() ->get('Posts');

        $posts = $postsService
            ->toObject()
            ->get(
                array('publicado'=>1),
                array(
                    'order'=> 'data DESC',
                )
            );

        $authorData = array(
            'name' => 'Jean Carlo Machado',
            'email' => 'cotato@jeancarlomachado.com.br',
            'uri' => 'http://jeancarlomachado.com.br/about'
        );

        $feed = new Feed;
        $feed->setTitle('Jean Carlo Machado\'s Blog');
        $feed->setLink('http://jeancarlomachado.com.br');
        $feed->setFeedLink('http://jeancarlomachado.com.br/feed', 'atom');
        $feed->addAuthor($authorData);

        $feed->setDateModified(time());

        $filter = new \Zend\Filter\StripTags(array('allowTags' => ''));

        foreach($posts as $post) {
            $content = $filter->filter($post->getConteudo()->showNChars(500)->getVal());
            $content = str_replace('&', '', $content);

            if (empty($content)) {
                continue;
            }


            $entry = $feed->createEntry();
            $entry->setTitle($post->getTitulo()->getVal());
            $entry->setLink('http://jeancarlomachado.com.br/post/visualizar/'.$post->getId()->getVal());
            $entry->addAuthor($authorData);
            $entry->setDateModified(time());

            $metatagsModel = $this->getServiceLocator()->get('Metatags');
            $where = array('class_name'=>$post->getTableModelName(),'related_id'=>$post->getId()->getBruteVal());
            $meta = $metatagsModel->toObject()->getOne($where);
            $description = $meta->getDescription()->getValue();

            if (empty($description)) {
                $description = $content;
            }

            $entry->setDescription($description);
            $entry->setContent($content);
            $feed->addEntry($entry);

        }

        echo $feed->export('atom');
        die;
    }

    public function indexAction()
    {
        $variables = array();

        if (isset($_GET['page']) && is_int((int) $_GET['page'])) {
            $this->currentPage = abs($_GET['page']);
        }

        $postsService = $this->getServiceLocator() ->get('Posts');
        $totalPosts =  $postsService->count(array('publicado' => 1));

        $variables['posts'] = $postsService
            ->toObject()
            ->get(
                array('publicado'=>1),
                array(
                    'order'=> 'data DESC',
                    'limit' => [ 'offset'=>$this->currentPage * self::POSTS_PER_PAGE, 'count'=> self::POSTS_PER_PAGE]
                )
            );

        $variables['currentPage'] = $this->currentPage;
        $variables['totalPosts'] = $totalPosts;
        $variables['totalPages'] = $totalPosts / self::POSTS_PER_PAGE;
        $this->viewModel->setVariables($variables);

        return $this->viewModel;
    }

    public function sobreAction()
    {
        $variables = array();

        $variables['row'] = $this->getServiceLocator()
            ->get('Posts')
            ->toObject()
            ->getOne(array('id'=>2));

        $this->viewModel->setVariables($variables);

        return $this->viewModel;
    }

    public function goalsAction()
    {
        $variables = array();

        $variables['row'] = $this->getServiceLocator()
            ->get('Posts')
            ->toObject()
            ->getOne(array('id'=>70));

        $this->viewModel->setVariables($variables);
        $this->viewModel->setTerminal(true);

        return $this->viewModel;
    }

    public function reportAction()
    {
        $variables = array();

        $variables['row'] = $this->getServiceLocator()
            ->get('Posts')
            ->toObject()
            ->getOne(array('id'=>55));

        $this->viewModel->setVariables($variables);
        $this->viewModel->setTerminal(true);

        return $this->viewModel;
    }
}
