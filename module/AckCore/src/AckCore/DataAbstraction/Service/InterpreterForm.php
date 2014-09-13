<?php
/**
 * interpretador dos formulários do ack
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
use \AckCore\Facade;
class InterpreterForm extends InterpreterAbstract
{
    /**
     * contexto de execução (coluna 1 ou 2)
     * @var [type]
     */
    protected $context = 1;
    const 	COL1 = 1;
    const  COL2 = 2;

    /**
     * constroi os elementos e os renderiza diretamente
     *
     * @param rowabstract $row linha de tabela
     *
     * @return void null
     */
    public function renderElementsFromRow($row)
    {
        $elements = $this->buildElementsFromRow($row);

        foreach ($elements as $element) {
            $element->render();
        }
    }

    /**
     * retorna HTMLElments à partir de uma linha do banco de dados
     * @param  SystemDbRowAbstract $row [description]
     * @return [type]              [description]
     */
    public function &buildElementsFromRow(\AckDb\ZF1\RowAbstract &$row)
    {
        $result = array();
        $tmpResult = array();

        $acceptedLang = Facade::getMainLanguage();
        $cConfig = $this->getCustomConfig();

        foreach ($row->vars as $key => $column) {

            if(isset($cConfig["showOnlyNotEmptyFields"])
               && ($cConfig["showOnlyNotEmptyFields"] == true)
               && !($column->getBruteVal())) {
                continue;
            }

            //testa se as colunas estão whitelist ou blacklisted
            if (!empty($cConfig) && !$this->renderColumnApproved($column,$key,$row,$cConfig)) {
                continue;
            }

            $config = $this->getConfigFromVariable($column);

            if ((isset($config["renderForm"]) && $config["renderForm"] == false)) {
                continue;
            }

            $elementType =& $config["HTMLElementType"];
            $permission =  $config["HTMLElementPermission"];

            //instancia o objeto
            $htmlElement = $this->getServiceLocator()->get('HtmlElementsManager')->getFactoryOf($elementType,$column);

            if (isset($config["title"])) {
                $htmlElement->setTitle($config["title"]);
            }
            //seta a permissão atual
            $htmlElement->setPermission($permission);
            $tmpResult[$key] = $htmlElement;
        }

        $ctx = $this->getContext();
        //adiciona o contexto do to render
        if (!empty($cConfig["toRenderCOL$ctx"])) {

            $toRender =& $cConfig["toRenderCOL$ctx"];
            ksort($toRender);
            $totalElements = count($toRender) + count($tmpResult);

            for ($i=0;$i<$totalElements;$i++) {

                if (isset($toRender[$i])) {
                        $result[$i] = $toRender[$i];
                } else {

                    if (!empty($tmpResult)) {
                        $result[$i] = array_shift($tmpResult);
                    } else {
                        $result[$i] = array_shift($toRender);
                    }
                }

            }
        } else {
            $result =& $tmpResult;
        }

        //layer de compatibilidade para o to render (este é colocado em ambas as colunas)
        if(!empty($cConfig["toRender"])) foreach($cConfig["toRender"] as $renderable) $result[] = $renderable;

        return $result;
    }

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

            } elseif (!empty($config["whitelist"])) {
                return in_array($key, $config["whitelist"]);
            }

            return false;
    }

    /**
     * retorna o contexto atual
     * @return [type] [description]
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * seta o contexto de renderização
     * @param [type] $context [description]
     */
    public function setContext($context)
    {
        if($context == self::COL2)
            $this->clearConfig();

        $this->context = $context;

        return $this;
    }
}
