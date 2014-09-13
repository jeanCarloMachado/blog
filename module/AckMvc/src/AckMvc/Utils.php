<?php
/**
 * utilitários para controllers
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
use AckCore\Object;
class Utils extends Object
{
    /**
     * retorna o cerne do nome completo de um controlador
     * caso receba \AckCore\Controller\ExemploController
     * a função retornará Exemplo
     * @param  [type] $fullControllerName [description]
     * @return [type] [description]
     */
    public static function getControllerCoreName($fullControllerName)
    {
        $result = str_replace("Controller", "", $fullControllerName);
        $result = explode("\\", $result);
        $result = end($result);

        return $result;
    }
    /**
     * se o nome for compatível com um nome de controlador
     * retorna true
     * @param  [type]  $name [description]
     * @return boolean [description]
     */
    public static function isValidName($name)
    {
        return preg_match("/^.*Controller$/", $name);
    }
    /**
     * se o nome for compatível com um nome de arquivo de controlador
     * retorna true
     * @param  [type]  $name [description]
     * @return boolean [description]
     */
    public static function isValidFileName($file)
    {
        return preg_match("/^.*Controller\.php$/", $file);
    }
    /**
     * se o nome for compatível com um nome de arquivo de controlador
     * retorna true
     * @param  [type]  $name [description]
     * @return boolean [description]
     */
    public static function getNameFromFile($file)
    {
        $file = explode(".",$file);

        return reset($file);
    }
}
