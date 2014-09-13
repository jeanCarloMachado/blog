<?php
/**
 * classe de debug
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   Ack
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */

namespace AckDevel\Debug;
use \Zend\Debug\Debug as ZendDebug;

/**
 * classe de debug
 *
 * @category AckDefault
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Debug extends ZendDebug
{
    /**
     * mostra um array e morre
     * @param  [type] $data [description]
     * @return [type] [description]
     */
    public static function dg($data, $throwException = false)
    {
        self::sw($data);

        if ($throwException) {
            throw new \Exception("Fim debug", 1);
        }

        die;
    }

    /**
     * mostra um array e continua a execuçao
     * @param  [type] $data [description]
     * @return [type] [description]
     */
    public static function sw($data)
    {
        // echo "<pre>";
        // print_r($data);
        self::dump($data);
    }
}
