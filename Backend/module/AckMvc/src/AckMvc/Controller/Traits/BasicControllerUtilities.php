<?php

namespace AckMvc\Controller\Traits;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\PluginManager;
use AckCore\Facade;

trait BasicControllerUtilities
{
    public function routerAjaxAction()
    {
        $action = (isset($this->ajax['action'])) ? $this->ajax['action'] : $this->ajax['acao'];
        $action = str_replace('-', '', $action);
        $action .= 'Ajax';

        if (!method_exists($this, $action)) {
            throw new \Exception('Não encontrou a action especificiada: '.$action);
        }

        $this->$action();

        return $this->response;
    }

    public function __construct()
    {
        $this->setViewModel(new ViewModel());

        if (!empty($_POST) && (isset($_POST['ajaxACK']) || isset($_POST['ajaxData']))) {
            $this->ajax = (isset($_POST['ajaxData'])) ? $_POST['ajaxData'] : $_POST['ajaxACK'];
            $this->ajax = json_decode($this->ajax, true);
            $this->bruteAjax = $this->ajax;
            $this->ajax = \AckCore\Utils\Arr::escapeArray($this->ajax);
        }
        $this->Init();
    }

    public function Init()
    {
    }

    /**
     * retorna as actions da classe extendida.
     *
     * @param bool $justName [description]
     *
     * @return [type] [description]
     */
    public function getActions($justName = true)
    {
        $actions = get_class_methods(get_called_class());

        foreach ($actions as $key => $method) {
            if (substr($method, -6) != 'Action') {
                unset($actions[$key]);
            } elseif ($justName) {
                $actions[$key] = substr($method, 0, -6);
            }
        }

        return $actions;
    }

    /**
     * retorna a url adaptada de acordo com a rota atual.
     *
     * @param [type] $action [description]
     *
     * @return [type] [description]
     */
    public function buildUrl($action = null)
    {
        $router = $this->getServiceLocator()->get('router');
        $request = $this->getServiceLocator()->get('request');

        $routeMatch = $router->match($request);
        $routeName = $routeMatch->getMatchedRouteName();

        $options = array('controller' => $this->getUrlClassName());

        if ($action) {
            $options['action'] = $action;
        }

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
