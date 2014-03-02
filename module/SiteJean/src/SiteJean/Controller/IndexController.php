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
     * @return [type] [description]
     */
    public function indexAction()
    {
        $variables = array();

        $variables['posts'] = $this->getServiceLocator()
            ->get('Posts')
            ->toObject()
            ->get();

        $this->viewModel->setVariables($variables);

        return $this->viewModel;
    }
}
