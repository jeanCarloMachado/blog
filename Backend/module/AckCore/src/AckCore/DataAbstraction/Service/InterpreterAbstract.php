<?php
/**
 * esta classe serve de base para outras que interpretam as colunas do banco
 * e transformam em resultados palpaveis para o usuário
 *
 * descrição detalhada
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
namespace AckCore\DataAbstraction\Service;

use Zend\View\Helper\AbstractHelper;
use \AckCore\Facade;
use AckCore\Stdlib\ServiceLocator\ServiceLocatorAware;

abstract class InterpreterAbstract extends AbstractHelper
{
    use ServiceLocatorAware;

    protected $customConfig = array();
    protected $priorityIterator =  0;
    protected $mergedConfig;

    /**
     * função que localiza padrões e remove duplicâncias
     * das colunas por exemplo _true _false das colunas de filtros
     * @param  [type] $columns [description]
     * @return [type] [description]
     */
    protected function prepareColumns(&$columns)
    {
        if(!is_array($columns)) return;

        foreach ($columns as $column => $value) {

            if (preg_match('/.*_false$/', $column)) {
                //se exiisteir as duas opções é considerado como
                //ou então ambos são removidos
                $trueVersion = substr($column,0, -6)."_true";
                if (array_key_exists($trueVersion, $columns)) {
                    unset($columns[$trueVersion]);
                    unset($columns[$column]);
                } else {
                    //em vez de colocar o valor como o passado
                    //coloca-se como false pois este é o campo false
                    $columns[substr($column,0, -6)] = 0;
                    unset($columns[$column]);
                }

            } elseif (preg_match('/.*_true$/', $column)) {
                $falseVersion = substr($column,0, -5)."_false";
                if (array_key_exists($falseVersion, $columns)) {
                    unset($columns[$falseVersion]);
                    unset($columns[$column]);
                } else {
                    $columns[substr($column,0, -5)] = $value;
                    unset($columns[$column]);
                }

            }
        }
    }

    /**
     * retorna um merge da configuração do
     * arquiovo de abstrações mais as configurações passadas
     * pelo usuário
     *
     * @return array config
     */
    final public function getMergedConfig()
    {
        if (empty( $this->mergedConfig )) {
            $path = __DIR__."/../config.php";
            $this->mergedConfig = require $path;

            $cConfig = $this->getCustomConfig();

            //seta a permissão
            if(isset($cConfig["permission"]))  $this->mergedConfig["elementsSettings"]["HTMLElementDefaultPermission"] = \AckCore\Permission::toNumber($cConfig["permission"]);

            $cConfig = (isset($cConfig["elementsSettings"])) ? $cConfig["elementsSettings"] : $cConfig;
            if (!empty($cConfig)) {
                $this->mergedConfig  = \AckCore\Utils\Arr::mergeReplacingOnlyFinalKeys($this->mergedConfig,array("elementsSettings" =>$cConfig));
            }
        }

        return $this->mergedConfig;
    }

    /**
     * retorna a configuração da coluna à partir de um objeto variavel
     * @param  SystemVarsVariable $variable [description]
     * @return [type]             [description]
     */
    public function getConfigFromVariable(\AckCore\Vars\Variable $variable)
    {
        return $this->getColumnConfig($variable->getColumnName(),$variable->getType()->getAlias());
    }

    /**
     * retorna o array de configuração para uma coluna passada to tipo variable
     * @param  SystemVarsVariable $variable [description]
     * @return [type]             [description]
     */
    final public function getColumnConfig($columnName, $type)
    {
        $result  = array();
        $this->resetPriority();
        $config = $this->getMergedConfig();

        $config = &$config["elementsSettings"];

        $matchFound = false;
        $priority = null;
        //pega as configurações que se aplicam e da merge das mesmas em uma configuração para retornar ao usuário
        do {
            $priority = $this->getPriority($priority);

            //pega o elemento de acordo com sua prioridade
            if ($priority == "names" && ($columnName)) {
                $match = null;
                $match = \AckCore\Utils\Arr::array_key_exists_from_match($columnName,$config["definitions"][$priority]);
                if ($match) {
                    $result =  $config["definitions"][$priority][$match];
                    break;
                }
            } elseif ($priority == "types" && ($type)) {

                $match = \AckCore\Utils\Arr::array_key_exists_from_match($type,$config["definitions"][$priority]);
                if ($match) {
                    $result = $config["definitions"][$priority][$match];
                }
            }

        } while ($priority);

        if (array_key_exists($columnName,$config)) $result = array_merge($result,$config[$columnName]);

        \AckCore\Utils\Arr::putOnlyIntexistentKeysRecursively($result,$config["definitions"]["fallback"][0]);

        if(empty($result["HTMLElementPermission"])) $result["HTMLElementPermission"] = $config["HTMLElementDefaultPermission"];

        return $result;
    }

    /**
     * retorna as prioridades em ordem de importancia
     * @param  [type] $last [description]
     * @return [type] [description]
     */
    public function getPriority($last = null)
    {
        $config = $this->getMergedConfig();
        $config =& $config["elementsSettings"];
        //do {
            if($config["priority"][$this->priorityIterator] == "controller" || $config["priority"][$this->priorityIterator] == $last )
                $this->priorityIterator++;

        //} while (isset($config["priority"][$this->priorityIterator]));
        return (isset($config["priority"][$this->priorityIterator])) ? $config["priority"][$this->priorityIterator] : null;
    }

    /**
     * reseta o iterador da prioridade
     * @return [type] [description]
     */
    public function resetPriority()
    {
        $this->priorityIterator = 0;
    }

    /**
     * seta a configuração do controlador
     * @param [type] $customConfig [description]
     */
    public function setCustomConfig(&$customConfig)
    {
        $this->customConfig = &$customConfig;

        return $this;
    }

    /**
     * pega a configuração do controlador
     * @param [type] $customConfig [description]
     */
    public function getCustomConfig()
    {
        return $this->customConfig;
    }

    public function clearConfig()
    {
        $this->mergedConfig = null;

        return $this;
    }

    //###################################################################################
    //################################# funções de utilização para classes membras###########################################
    //###################################################################################
    protected function isAllowedToRender(&$row,$key)
    {
        if($key == "fakeid" || !$row->vars[$key]) return false;
        else if($key == "id" && !isset($row->vars["fakeid"])) return false;
        else if($key == "visivel" && isset($this->customConfig["disableVisible"])) return false;
        return true;
    }
    //###################################################################################
    //################################# END funções de utilização para classes membras########################################
    //###################################################################################

    /**
     * retorna  um booeando se uma coluna deve ser renderizaa ou não
     * @param  [type] $element [description]
     * @param  [type] $key     [description]
     * @param  [type] $row     [description]
     * @param  [type] $config  [description]
     * @return [type] [description]
     */
    public function renderColumnApproved(&$element,$key,&$row,&$config)
    {
            if (!isset($config["whitelist"])) {
                    //teste obrigatório que sempre acontece
                    //remove a entrada de colunas de outros idiomas
                    $exploded = explode("_",$row->vars[$key]->getColumnName());
                    if (count($exploded) > 1) {

                            $lang = end($exploded);
                            if($lang != "pt" && in_array($lang, Facade::getLanguageSuffixes())) return false;
                    }

                    if (isset($config["blacklist"])) {
                            if(in_array($key, $config["blacklist"])) return false;

                            return true;
                    }
                    //exceções
                    if($key == "id" || $key == "visivel") return false;

            } elseif (!empty($config["whitelist"])) return in_array($key, $config["whitelist"]);

            return false;
    }

}
