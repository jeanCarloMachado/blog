<?php
/**
 * interpretador de buscas retornando os requltados das pesquisas
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
use \AckCore\Utils\Date;
class InterpreterSearch extends InterpreterAbstract
{
    protected $relatedModel;

    /**
     * recebe uma clausula where e a edita com o tipo de busca
     * relacionada ao tipo de elemento
     * @param  [type] $ajax   [description]
     * @param  [type] $where  [description]
     * @param  [type] $params [description]
     * @return [type] [description]
     */
    public function alterQueryClausules(&$ajax,&$where,&$params)
    {
        if (!is_array($where)) {
            $where = array();
        }

        $filters = $this->getValidFilters($ajax);
        $this->prepareColumns($filters);

        if (empty($filters)) {
            return;
        }

        foreach ($filters as $column => $value) {
            $schema = $this->getRelatedModel()->getColumnSchema($column);

            if(empty($schema)) continue;

            $schema = reset($schema);
            $realColName = $schema["Field"];
            $type = $schema["Type"];

            //caso seja uma data testa se a mesma é válida
            if(($type == "datetime" || $type == "date") && !Date::valid($value)) continue;

            $cfg = $this->getColumnConfig($column,$type);

            if(empty($cfg["SearchPattern"])) continue;

            $resultArray  = \AckDb\ZF1\ClausulePatternsAliases::getTransoformedPattern($cfg["SearchPattern"], $realColName, $value);
            if ($resultArray) {
                unset($where[$column]);
                $where = array_merge($where,$resultArray);
            }
        }
    }

    /**
     * remove campos de filtros que não são válidos
     * @param  [type] $ajax [description]
     * @return [type] [description]
     */
    public function getValidFilters($ajax)
    {
        $filters =&  $ajax["filters"];

        if(empty($filters)) return $filters;

        foreach ($filters as $key => $element) {
            if(empty($element)) unset($filters[$key]);
        }

        return $filters;
    }

    /**
     * retorna o modelo relacionado com esta busca
     * @return [type] [description]
     */
    public function getRelatedModel()
    {
        return $this->relatedModel;
    }
    /**
     * seta o módulo relacionado
     * @param [type] $relatedModel [description]
     */
    public function setRelatedModel($relatedModel)
    {
        $this->relatedModel = $relatedModel;

        return $this;
    }
}
