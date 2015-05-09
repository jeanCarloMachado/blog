<?php
/**
 * serviço de breadcrumbs do ack
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
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
class BreadCrumbs extends AbstractHelper
{
    protected $urlParameters = array();
    protected $baseTitle;
    public $stack = array();
    protected $pointer = -1;
    protected static $pluralizerStatus = true;

    public static function Factory($conf)
    {
        $instance = new BreadCrumbs;

        $instance->urlParameters = \AckCore\Facade::getInstance()->getParamsRoute();
        //###################################################################################
        //################################# gambiarras de compatibilidade ###########################################
        //###################################################################################
        if(is_string($conf)) $instance->baseTitle = $conf;
        else if (is_array($conf)) {
            if($conf['disablePluralizer'])
                self::disablePluralizer();
            if($conf["title"])
                $instance->baseTitle = $conf["title"];
        }
        //###################################################################################
        //################################# END gambiarras de compatibilidade ########################################
        //###################################################################################

        $namespace = $instance->urlParameters["__NAMESPACE__"];

        if (substr($namespace, 0, 3) == "Ack" || preg_match("/Ack/",$namespace) || "ControlaCar") {

            $url = "/ack/".$instance->urlParameters["__CONTROLLER__"];

            if(!self::$pluralizerStatus)
                $str = $instance->baseTitle;
            else {
                $pluralizer = new \AckCore\View\Helper\Pluralizer;
                $str = $pluralizer($instance->baseTitle);
            }

            $instance->stack[] = array("url"=>strtolower($url),"string"=>$str);

            if ($instance->urlParameters["action"] == "editar") {
                $instance->stack[] = array("url"=>"javascript:void(0);","string"=>"Editar ".strtolower($instance->baseTitle));
            } elseif ($instance->urlParameters["action"] == "incluir") {
                $instance->stack[] = array("url"=>"javascript:void(0);","string"=>"Incluir ".strtolower($instance->baseTitle));
            }
            } else {
                trigger_error("breadcrumb não implementado para este namespace: $namespace",E_USER_NOTICE);
        }
        $instance->resetIterator();

        return $instance;
    }

    public function __invoke()
    {
        throw new \Exception("invoke não implementado");
    }

    public function getStr()
    {
        return $this->stack[$this->pointer]["string"];
    }

    public function getUrl()
    {
        return $this->stack[$this->pointer]["url"];
    }

    public function increment()
    {
        $this->pointer++;

        return $this;
    }

    public function getNext()
    {
        if(isset($this->stack[$this->pointer + 1]))

                return ($this->stack[$this->pointer + 1]);

        return null;
    }

    public function getCurrent()
    {

            if(isset($this->stack[$this->pointer]))

                return  $this->stack[$this->pointer];

            return null;
    }

    public function resetIterator()
    {
        $this->pointer = 0;
    }

    public function getStack()
    {
        return $this->stack;
    }

    public function setStack($stack)
    {
        $this->stack = $stack;

        return $this;
    }
    public function getPointer()
    {
        return $this->pointer;
    }

    public function setPointer($pointer)
    {
        $this->pointer = $pointer;

        return $this;
    }

    public function getTotal()
    {
        return $this->pointer;
    }

    public function getBaseTitle()
    {
        return $this->baseTitle;
    }

    public function setBaseTitle($baseTitle)
    {
        $this->baseTitle = $baseTitle;

        return $this;
    }

    public static function disablePluralizer()
    {
        self::$pluralizerStatus = false;

        return ture;
    }
}
