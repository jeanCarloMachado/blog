<?php
/**
 * gerenciador de htmlELements
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\HtmlElements;

use AckCore\Facade;
use Zend\View\Helper\AbstractHelper;
class HtmlElementsManager extends AbstractHelper 
{
    /**
     * nome do módulo principal do site
     * a classe usa esse parâmetro para
     * descobrir se existe um novo html element
     * que sobreescreve o funcionamento do
     * defalut caso exista ele pega aquel
     * caso não ele pega os de AckCore
     * @var [type]
     */
    protected $moduleName = null;
    const DEFAULT_PREFFIX = "\AckCore\HtmlElements\\";

    public function __construct()
    {
    }

    public function __invoke()
    {
        return $this;
    }

    public function getInstanceOf($elementName = "Input")
    {
        $mainModuleName = Facade::getMainModuleName();
        $className = $mainModuleName."\HtmlElements\\".$elementName;

        if(!class_exists($className)) $className = self::DEFAULT_PREFFIX.$elementName;

        $instance = new $className;

        return $instance;
    }

    public function getFactoryOf($elementName = "Input", $parameters = null)
    {
        $mainModuleName = Facade::getMainModuleName();
        $className = $mainModuleName."\HtmlElements\\".$elementName;

        if(!class_exists($className)) $className = self::DEFAULT_PREFFIX.$elementName;

        $instance = $className::Factory($parameters);

        return $instance;
    }

    //###################################################################################
    //################################# getters and setters ###########################################
    //###################################################################################

    public function getModuleName()
    {
        return $this->moduleName;
    }

    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }
    //###################################################################################
    //################################# END getters and setters ########################################
    //###################################################################################
}
