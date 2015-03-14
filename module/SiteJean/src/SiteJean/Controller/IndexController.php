<?php
namespace SiteJean\Controller;
use AckMvc\Controller\Base;
/**
 * página incial do sistema
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class IndexController extends Base
{
    /**
     * página incial do site
     */
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
}
