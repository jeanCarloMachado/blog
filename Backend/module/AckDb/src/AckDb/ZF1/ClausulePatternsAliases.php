<?php
/**
 * esta classe contém padrões de buscas com
 * nomes facilitadores de busca
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
namespace AckDb\ZF1;
class ClausulePatternsAliases
{
    protected static $patterns = array(
        "DoubleLike" => array("ColumnPattern" => "#COLUMN LIKE","ValuePattern" => "%#VALUE%"),
        "Equals" => array("ColumnPattern" => "#COLUMN","ValuePattern" => "#VALUE"),
        "MajorOf" => array("ColumnPattern" => "#COLUMN","ValuePattern" => "  < #VALUE"),
    );
    public static function getPatternByAlias($alias)
    {
        return self::$patterns[$alias];
    }
    /**
     * esta função retorna o array de uma coluna sobreescrito com os valores reais.
     * @param  [type] $patternAlias [description]
     * @param  [type] $column       [description]
     * @param  [type] $value        [description]
     * @return [type] [description]
     */
    public static function getTransoformedPattern($patternAlias, $column, $value)
    {
        $pattern = self::getPatternByAlias($patternAlias);

        $result = array();

        $key = str_replace("#COLUMN", $column, $pattern["ColumnPattern"]);
        $val = str_replace("#VALUE", $value, $pattern["ValuePattern"]);

        $result[$key] = $val;

        return $result;
    }
}
