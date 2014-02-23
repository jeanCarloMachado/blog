<?php
/**
 * classe de manipulação de números
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

namespace AckCore\Utils;
class Number
{
    const AFTER_COMMA_NUMBERS = 3;

    public static function convertDate($data, $formato)
    {
        $formato=utf8_decode($formato);

        return utf8_encode(strftime($formato,strtotime($data)));
    }

    /**
     * retorna um range de números à partir de um inical
     * até um total count
     * (pode ser utilizado para selects de data offset=1950 count = 50)
     * @param  [type] $offset [description]
     * @param  [type] $count  [description]
     * @return [type] [description]
     */
    public static function getRange($offset,$count)
    {
        $result = array();
        for ($i = $offset; $i<($offset + $count); $i++) {
            $result[] = $i;
        }

        return $result;
    }
    /**
     * TRANSFORMA UM NÚMERO.00
     * 00,000
     * @param  float  $num [description]
     * @return [type] [description]
     */
    public static function fromInternational($num)
    {
        $num = $num;
        $arr = explode('.',$num);
        $second = $arr[1];
        $second = substr($second, 0, self::AFTER_COMMA_NUMBERS);

        if(!$second)

            return $arr[0];
        else
            $second = self::removeBehindZeros($second);

        $result = $arr[0].','.$second;

        return $result;
    }

    public static function fromBrazil(string $num)
    {
        $num = (string) $num;
        $num = str_replace('.', '', $num);
        $arr = explode(',',$num);

        if (count($arr)>1) {

            $second = (string) $arr[1];
            $second = substr($second, 0, self::AFTER_COMMA_NUMBERS);
            self::removeBehindZeros($second);

            if(!$second)

                return $arr[0];

            return (float) $arr[0].'.'.$second;
        }

        return (int) $num;
    }

    public static function removeBehindZeros(&$num)
    {
        $counter = strlen((string) $num);
        while ($counter > 0) {
            if((string) $num[$counter] == '0')
                $num = substr($num, 0, -1);
            $counter--;
        }
    }

    /**
     * coloca $size (0)s na frente de num
     * @param  [type]  $num  [description]
     * @param  integer $size [description]
     * @return [type]  [description]
     */
    public static function putDigitsInfront(&$num,$size=5)
    {
        $otherDigits = $size - strlen($num);
        $i=0;
        while ($i<$otherDigits) {
            $num = ('0'.$num);
            $i++;
        }

        return $num;
    }

    /**
     * DEPRECATEDD
     * transforama um float do padrao internacional
     * para o padrao do brasil
     * @param  [type] $num [description]
     * @return [type] [description]
     */
    public static function toBr($num)
    {
        return str_replace('.',',',(string) $num);
    }

    /**
     * DEPRECATEDD
     * transforama um float do padrao internacional
     * para o padrao do brasil
     * @param  [type] $num [description]
     * @return [type] [description]
     */
    public static function fromBr($num)
    {
        return (float) str_replace(',','.',(string) $num);
    }

    public static function clean($num)
    {
        $clean = "";

        $num = (string) $num;

        for ($i = 0; $i < strlen((string) $num);$i++) {
            if (is_numeric((int) ($i))) {
                $clean.=$num[$i];
            }
        }

        return (int) $clean;
    }

    /**
     * converte um número em pixel em centímetros
     * @param  [type] $pixelSize [description]
     * @param  [type] $dpi       [description]
     * @return [type] [description]
     */
    public static function pixelToCentimeter($pixelSize, $dpi)
    {
        $result =  $pixelSize * 2.54 / $dpi;

        return round($result,2);
    }

    // public static function pixelToCentimeter($pixelSize, $dpi)
    // {
    // 	$result =  $pixelSize * $dpi / 2.54;

    // 	return round($result,2);
    // }

    public static function minVal(&$val,$min)
    {
        if ($val < $min) {
            $val = $min;
        }

        return $val;
    }

    public function roundUp(float $num)
    {
        return self::sRoundUp($num);
    }

    public static function sRoundUp($num)
    {
        return ceil($num);
    }

    public static function daysToPeriod($days)
    {

        if (!is_int((int) $days)) {
            throw new \Exception('Esperando inteiro', 1);
        }

        if ($days == 30 || $days == 31) {
            return 'mês';
        } elseif ($days == 365) {
            return 'mês';
        }

        return $days.' dias';
    }
}
