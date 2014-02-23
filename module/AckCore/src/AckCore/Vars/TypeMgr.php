<?php
/**
 * gerenciador dos tipos de variáveis do sitema
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
//removi a extensão daqui em caso de problemas descomentar Dom Ago  4 14:53:43 BRT 2013
namespace AckCore\Vars;
//use AckCore\Object;
class TypeMgr //extends Object
{
    /**
     * é passado argumentos a classe polimorfica
     * a qual de acordo com esses argumentos intancia
     * a classe necessária
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public static function getInstance($params,$var)
    {
        $className =& $params;
        $obj = null;

        if (!$className) {
            $obj = new \AckCore\Vars\TypeDefault;
        } elseif ($className=="int" || substr($className, 0,3)=="int") {
            $obj = new \AckCore\Vars\TypeInt;
        } elseif (substr($className, 0,7)=="decimal" || substr($className,0,5) == "float") {
            $obj = new \AckCore\Vars\TypeFloat;
        } elseif ($className=="money") {
            $obj = new \AckCore\Vars\TypeMoney;
        } elseif (preg_match("/.*date.*/", $className) || preg_match("/.*time.*/", $className)) {
            $obj = new \AckCore\Vars\TypeDate;
        } else {
            $obj = new \AckCore\Vars\TypeDefault;
        }
        $obj->setAlias($className);
        $obj->setVar($var);

        return $obj;
    }
}
