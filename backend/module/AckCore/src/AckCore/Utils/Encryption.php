<?php

/**
 * funções de encriptação
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
namespace AckCore\Utils;
class Encryption
{
    public $pubkey = '...public key here...';
    public $privkey = '...private key here...';
    private static $randomKey = "çalskdj1234";

    public static function strong($str)
    {
        return md5($str);
    }

    public static function medium($str)
    {
        return md5($str);
    }

    public static function weak($str)
    {
        return base64_encode($str);
    }

    public static function encrypt($str)
    {
        return md5($str);
    }

    // Encrypting
    public static function encode($string)
    {
        $result =  base64_encode($string);
        $result.=self::$randomKey;

        return $result;
    }

    // Decrypting
    public static function decode($string)
    {
        $string = substr($string, 0, -(strlen(self::$randomKey)));

        return base64_decode($string);
    }

}
