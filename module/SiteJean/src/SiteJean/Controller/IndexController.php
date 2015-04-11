<?php
namespace SiteJean\Controller;
use AckMvc\Controller\Base;
class IndexController extends Base
{
    public function indexAction()
    {
        $variables = array();

        $variables['posts'] = $this->getServiceLocator()
            ->get('Posts')
            ->toObject()
            ->get(array('publicado'=>1),array('order'=> 'data DESC'));

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
