<?php
/**
 * funções relativas às permissões do sistema
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
namespace AckCore;
class Permission
{
    /**
     * transforma uma permissão alfa em numérica
     * @param  [type] $str [description]
     * @return [type] [description]
     */
    public static function toNumber($str)
    {
        $arr = str_split($str);

        if ($arr[0] == "-") {
            if($str == "-rw") return 0;
            else if($str == "-w") return 1;
            else if($str == "-r") return 0;
        } else {
            if($arr[0] == "+") $str = substr($str,1);
            if($str == "rw") return 2;
            else if($str == "w") return 2;
            else if($str == "r") return 1;
        }

        if(is_int((int) $str)) return (int) $str;

        throw new \Exception("Nenhuma permissão econtrada para o padrão < ".($str)." >");

        return $result;
    }
}
