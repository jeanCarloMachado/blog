<?php
/**
 * facilitadores para controllers
 *
 * AckDefault - Cub
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckMvc\Controller\Traits;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\PluginManager;

use AckCore\Facade;

/**
 * facilitadores para controllers
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
trait BasicControllerUtilities
{

    public function routerAjaxAction()
    {
        $action = (isset($this->ajax['action'])) ? $this->ajax['action'] : $this->ajax['acao'];
        $action = str_replace('-', '', $action);
        $action.= 'Ajax';

        if (!method_exists($this, $action)) {
            throw new \Exception('Não encontrou a action especificiada: '.$action);
        }

        $this->$action();

        return $this->response;
    }

    public function __construct()
    {
        $this->setViewModel(new ViewModel());

        //guarda o ajax
        if (!empty($_POST) && (isset($_POST["ajaxACK"]) || isset($_POST["ajaxData"]))) {

            $this->ajax  = (isset($_POST["ajaxACK"])) ? json_decode($_POST["ajaxACK"],true) : json_decode($_POST["ajaxData"],true);
            $this->bruteAjax = $this->ajax;
            $this->ajax = \AckCore\Utils\Arr::escapeArray($this->ajax);
        }
        $this->Init();
    }

    public function Init()
    {

    }

     /**
     * retorna as actions da classe extendida
     * @param  boolean $justName [description]
     * @return [type]  [description]
     */
    public function getActions($justName = true)
    {
        $actions = get_class_methods(get_called_class());

        foreach ($actions as $key => $method) {
            if(substr($method, -6) != 'Action')
                unset($actions[$key]);
            else if($justName)
                $actions[$key] = substr($method, 0,-6);
        }

        return $actions;
    }

      /**
     * retorna a url adaptada de acordo com a rota atual
     * @param  [type] $action [description]
     * @return [type] [description]
     */
    public function buildUrl($action=null)
    {
        $router = $this->getServiceLocator()->get('router');
        $request = $this->getServiceLocator()->get('request');

        $routeMatch = $router->match($request);
        $routeName = $routeMatch->getMatchedRouteName();

        $options = array('controller'=>$this->getUrlClassName());

        if($action) $options['action'] = $action;

        $url = $this->plugin('url')->fromRoute($routeName, $options);

        $url = Facade::getEnderecoSite().$url;

        return $url;
    }

    protected function getUrlClassName()
    {
        $str = get_called_class();
        $str = explode('\\', $str);
        $str = end($str);
        $str = str_replace('Controller', '', $str);
        $str = strtolower($str);

        return $str;
    }

    public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }

    public function setPluginManager(PluginManager $plugins)
    {
        $this->plugins = $plugins;
        $this->plugins->setController($this);

        return $this;
    }

    public function getPluginManager()
    {
        if (!$this->plugins) {
            $this->setPluginManager(new PluginManager());
        }

        return $this->plugins;
    }

    public function plugin($name, array $options = null)
    {
        return $this->getPluginManager()->get($name, $options);
    }
}
