<?php

/**
 * contrutor automático de telas utilizando html'elements,
 * esta sesão está depreciada e deve ser substituída pelos interpreter em
 * data abstraction
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
namespace AckCore\HtmlElements;

use AckCore\Object;
class ListInterpreter extends Object
{
        const DEFAULT_PERMISSION = -1;
        /**
         * retorna o cabeçalho da listagem da sessão do ack
         * @param  [type] $row    [description]
         * @param  array  $config [description]
         * @return [type]         [description]
         */
        public function renderHeader($config = array())
        {
            //###################################################################################
            //################################# adiciona as colunas que não existem na linha passada###########################################

             if (isset($config['whitelist'])) {
                foreach ($config['whitelist'] as $element) {
                    if (!array_key_exists($element, $config['row']->vars)) {
                        $config['row']->vars[$element] = new \AckCore\Vars\Variable();
                        $config['row']->vars[$element]->table = $config['row']->vars["id"]->table;
                        $config['row']->vars[$element]->columnName = $element;
                    }
                }
            }
             //###################################################################################
            //###################################################################################
            //################################# END adiciona as colunas que não existem na linha passada########################################
            //###################################################################################

            $row = $config['row'];
            $totalSpace = 700;
            $totalElements = $this->getTotalElements($row,$config);
            $spaceUnit = (isset($config["columnSpacing"])) ? $config["columnSpacing"] : (int) ($totalSpace / $totalElements);
            $counter = 0;
            //ordena as colunas do objeto de acordo com o whitelist se este exisir.
            if (isset($config["whitelist"]) && !empty($config["whitelist"])) {
                $newSort = array();
                foreach ($config["whitelist"] as $element) {
                        $newSort[$element] = $row->vars[$element];
                }
                $row->vars = $newSort;
            }

            foreach ($row->vars as $key => $element) {

                if(!$this->renderColumnApproved($element,$key,$row,$config) || !$row->vars[$key]) continue;
                /**
                 * coloca o espaçamento que vem no configurador, caso
                 * este seja passado
                 */
                if(isset($config["elementsSettings"][$key]["columnSpacing"]))
                        $elemetSpaceUnit = $config["elementsSettings"][$key]["columnSpacing"];
                else
                        $elemetSpaceUnit = $this->getExceptionConfig($key,$config,$spaceUnit);

                if($counter > $totalElements) break;

                /**
                 * mostra a chamada em php se building  = 1
                 */
                $element = ListHeaderEntry::Factory($row->vars[$key])->setWidth($elemetSpaceUnit);

                if(isset($config["elementsSettings"][$key]["orderSelector"])) $element->enableOrderSelector();

                $element->setPermission('+rw');
                $element->render();
                $counter++;
            }

        }

        /**
         * array de exceções para os testes de renderizações de colunas
         * @param  [type] $key     [description]
         * @param  [type] $config  [description]
         * @param  [type] $spacing [description]
         * @return [type]          [description]
         */
        public function getExceptionConfig($key,&$config,$spacing)
        {
                if($key == "id" ) return 20;
                if($key == "visivel") return 20;

                return $spacing;
        }
        /**
         * retorna  um booeando se uma coluna deve ser renderizaa ou não
         * @param  [type] $element [description]
         * @param  [type] $key     [description]
         * @param  [type] $row     [description]
         * @param  [type] $config  [description]
         * @return [type]          [description]
         */
        public function renderColumnApproved(&$element,$key,&$row,&$config)
        {
            if($key == "visivel" && isset($config["disableVisible"])) return false;

            if (!isset($config["whitelist"])) {

                //teste obrigatório que sempre acontece
                //remove a entrada de colunas de outros idiomas
                $exploded = explode("_",$row->vars[$key]->getColumnName());
                if (count($exploded) > 1) {

                        $lang = end($exploded);
                        if($lang != "pt" && in_array($lang, \AckCore\Facade::getLanguageSuffixes()))

                                return false;
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
         * retorna o total de elementos que uma página
         * para a renderização tem
         * @param  [type] $row    [description]
         * @param  [type] $config [description]
         * @return [type]         [description]
         */
        public function getTotalElements(&$row,&$config)
        {
                $total  = 0;

                if (isset($config["whitelist"])) {
                        $total = count($config["whitelist"]);
                } else {
                        $total =  count($row->vars);
                        $maxElements = 100;
                        $totalElements = 5;
                        assert(0,"Esta função não está com o funcionamento oK");

                        if ($totalElements > $maxElements) {
                                $totalElements = $maxElements;
                        }
                }

                return $total;
        }
}
