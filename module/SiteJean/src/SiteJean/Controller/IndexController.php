<?php
namespace SiteJean\Controller;

use AckMvc\Controller\Base;

class IndexController extends Base
{
    const POSTS_PER_PAGE = 1;
    private $currentPage = 0;

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
