<?php
/**
 * controller de base para todos os demais
 *
 * PHP version 5
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckMvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AckCore\Observer\Traits\Observable;
use AckMvc\Controller\Traits\BasicControllerUtilities;
/**
 * controlador de base para todos os outros do sistema, os do front devem extender este quando um menos genérico
 * nao se faz existente
 */
abstract class Base extends AbstractActionController
{
    use Observable;
    use BasicControllerUtilities;

    protected static $cache = null;
    protected $models = array("default"=> "\AckContent\Model\Texts");
    public $ajax = array();
    protected $bruteAjax = array();
    protected $viewModel = null;
    protected static $defaultModelKey = "default";
    protected $baseViewFolder = "ack-core";
    protected $ajaxObj;

    public function getAjax()
    {
        if(empty($this->ajaxObj)) $this->ajaxObj = new \AckCore\Utils\Ajax($this->ajax);

        return $this->ajaxObj;
    }

        /**
     * plugin manager necessita desta função
     */
    public function Init()
    {

        $this->attach('AckUsers\Access\Observer\Access');
        $event = new \AckCore\Event\Event;
        $event->setType(\AckCore\Event\Event::TYPE_ACCESS_REQUEST);
        $this->notify($event);
    }

    public function getDefaultViewFolder()
    {
        $str = get_called_class();
        $moduleName = explode('\\', $str);
        $moduleName = reset($moduleName);
        \AckCore\Utils\String::getZF2ViewFormat($moduleName);

        $str = explode('\\', $str);
        $baseFolder = $moduleName;
        $str = end($str);

        $str = str_replace("Controller", "", $str);
        $str = $baseFolder."/".$str;
        $str = strtolower($str);

        return $str;
    }

    public function getUrlClassName()
    {
        $str = get_called_class();
        $str = explode('\\', $str);
        $str = end($str);
        $str = str_replace("Controller", "", $str);
        $str = strtolower($str);

        return $str;
    }

    public function getMainPackageName()
    {
        return $this->getUrlClassName();
    }

    public function getViewModel()
    {
        return $this->viewModel;
    }

    public function setViewModel($viewModel)
    {
        $this->viewModel = $viewModel;

        return $this;
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
            if(substr($method, -6) != "Action")
                unset($actions[$key]);
            else if($justName)
                $actions[$key] = substr($method, 0,-6);
        }

        return $actions;
    }

    /**
     * [getMainModel description]
     * @return [type] [description]
     */
    public function getMainModel()
    {
        return $this->models[self::$defaultModelKey];
    }

    /**
     * retorna o modelo principal do sistema
     * @param  [type] $alias [description]
     * @return [type] [description]
     */
    public function getModelName($alias=null)
    {
        if(is_null($alias))
            $alias = self::$defaultModelKey;

        if(!isset($this->models[$alias]))
            throw new \Exception("não há modelo relacionado com esse controlador: ".get_called_class()) ;

        return $this->models[$alias];
    }

    public function getControllerOnRoute()
    {
        return strtolower($this->params()->fromRoute("__CONTROLLER__"));
    }

     public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }
}
