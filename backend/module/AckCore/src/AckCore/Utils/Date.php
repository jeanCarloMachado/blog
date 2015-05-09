<?php
/**
 * classe base para manipulação de datas
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
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\Utils;
/**
 * classe básica para a manipulação de datas
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Date
{
    /**
     * data
     * @var string
     */
    protected $_val;
    /**
     * description
     * @var \AckCore\Utils\Date_Day
     */
    public $day;

    /**
     * description
     * @var \AckCore\Utils\Date_Month
     */
    public $month;

    /**
     * description
     * @var \AckCore\Utils\Date_Year
     */
    public $year;

    private static $_separators = array('-','/','.');

    /**
     * contrutor quando deseja-se lidar com uma data na forma de objeto
     * @param [type] $strDate [description]
     * @param string $mask    [description]
     */
    public function __construct($strDate = null,$mask = 'Y-m-d')
    {

        if (!empty($strDate)) {

            /**
             * testa se existe um separador compatível
             * caso sim o usa
             */
            reset(self::$_separators);
            while (current(self::$_separators)) {

                $arrMask = explode(current(self::$_separators),$mask);

                if (count($arrMask) > 1) {
                    $separator = current(self::$_separators);
                    break;
                }

                next(self::$_separators);
            }
            /**
             * para cada elemento da mascara
             * coloca o elemento do array no lugar correspondente
             * @var [type]
             */
            foreach ($arrMask as $maskElementId => $maskElement) {

                $dateElement = explode($separator,$strDate);
                $dateElement = $dateElement[$maskElementId];

                switch ($maskElement) {
                    case 'd':
                        $this->day = new \AckCore\Utils\Date\Day;
                        $this->day->setVal($dateElement);
                    break;
                    case 'm':
                        $this->month = new \AckCore\Utils\Date\Month;
                        $this->month->setVal($dateElement);
                    break;
                    case 'y':
                        $this->year = new \AckCore\Utils\Date\Year;
                        $this->year->setVal($dateElement);
                    break;
                    case 'Y':
                        $this->year = new \AckCore\Utils\Date\Year;
                        $this->year->setVal($dateElement);
                    break;
                }
            }
        }
    }

    public static function valid($date)
    {
        $result = true;

        if(strlen($date) < 4) $result = false;

        return $result;
    }

    /**
     * testa se a primeira data é maior ou igual que a segunda
     * @param  [type] $date1 [description]
     * @param  [type] $date2 [description]
     * @return [type] [description]
     */
    public static function firstIsGraterOrEqualToSecond($date1,$date2)
    {

        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        if ($date1 >= $date2) {
            return true;
        }

        return false;
    }
    /**
     * retorna o datetime de agora
     * @return [type] [description]
     */
    public static function now()
    {
        return date(self::getDefaultDateTimeFormat());
    }
    /**
     * retorna o padrão zerado do sistema
     * @return [type] [description]
     */
    public static function defZeroDate()
    {
        return '0000-00-00 00:00:00';
    }
    /**
     * retona o dia de hoje
     * @return [type] [description]
     */
    public static function today()
    {
        return date(self::getDefaultDateFormat());
    }
    /**
     * retorna o formato default
     * @return [type] [description]
     */
    public static function getDefaultDateTimeFormat()
    {
        return 'Y-m-d H:i:s';
    }
    /**
     * retorna o formato default
     * @return [type] [description]
     */
    public static function getDefaultDateFormat()
    {
        return 'Y-m-d';
    }
    /**
     * retorna o formato default
     * @return [type] [description]
     */
    public static function getDefaultHourFormat()
    {
        return 'H:i:s';
    }

    public static function getTime()
    {
        return date(self::getDefaultHourFormat());
    }

    /**
     * pega um datetime e retorna somente a data
     * @param unknown $dateTime
     */
    public static function getJustDate($dateTime)
    {
        $result = explode(' ',$dateTime);

        return reset($result);
    }
    /**
     * à partir de um datetime retorna somente a data
     * @param  [type] $dateTime [description]
     * @return [type] [description]
     */
    public static function getOnlyDate($dateTime)
    {
        return self::getJustDate($dateTime);
    }
    /**
     * muda os separadores de uma data
     * @param  [type] $date      [description]
     * @param  string $separator [description]
     * @return [type] [description]
     */
    public static function putSeparators($date,$separator = '-')
    {
        if(strlen($date) != 8)	$date = '00000000';

        $result = substr($date, 0, 4);
        $result.= $separator;
        $result.= substr($date, 4, 2);
        $result.= $separator;
        $result.= substr($date, 6, 2);

        return $result;
    }
    /**
     * transforma uma data no formato d/m/Y para o formato y-m-d
     * @param  [type] $date [description]
     * @return [type] [description]
     */
    public static function toMysql($date,$separator='-')
    {
        $tmp =  array_reverse(explode($separator,$date));

        if (strlen($tmp[0])<4) {
            $datePrefix = 20;
            $godDate = $datePrefix.$tmp[0];
            $tmp[0] = $godDate;
        }
        $result =  implode('-',$tmp);

        if (!self::valid($result)) return null;
        return $result;
    }
    /**
     * transforma uma data no formato y-m-d para o formato d/m/Y
     * @param  [type] $date [description]
     * @return [type] [description]
     */
    public static function fromMysql($date,$separator='/',$showTime = false)
    {

        $date = (!empty($date)) ? $date : '0000-00-00';

        $tmp =  array_reverse(explode('-', substr($date, 0, 10)));

        if (strlen($tmp[2])<4) {
            $datePrefix = 20;
            $godDate = $datePrefix.$tmp[0];
            $tmp[2] = $godDate;
        }

        $result = implode($separator,$tmp);
        if($showTime) $result.=  substr($date, 10);

        if (!self::valid($result)) return null;
        return $result;
    }

    /**
     * testa se dateToTest está entre date1 e date2
     * @param  [type] $date1          [description]
     * @param  [type] $date2          [description]
     * @param  [type] $dateToTest     [description]
     * @param  string $format='Y-m-d' [description]
     * @return [type] [description]
     */
    public function betweenDates($date1,$date2,$dateToTest,$format='Y-m-d')
    {

        $date1 =strtotime( $date1);
        $date2 = strtotime( $date2);
        $dateToTest =strtotime( $dateToTest);

        if ($dateToTest >= $date1 && $dateToTest <= $date2) {
            return true;
        }

        return false;
    }

    public function getVal()
    {
        return $this->_val;
    }

    public function setVal($val)
    {
        $this->_val = $val;
    }

    public static function daysFromNow($qtd = 0)
    {
        return date(self::getDefaultDateFormat(),strtotime(self::now(). ' + $qtd days'));
    }

    public static function removeYear($date,$separator='/')
    {
        $date = explode($separator, $date);
        $date = $date[0].$separator.$date[1];

        return $date;
    }

    public static function getMonth($date,$separator='-')
    {
        $date = explode($separator,$date);

        return $date[1];
    }

    public static function getYear($date,$separator='-')
    {
        $date = explode($separator,$date);

        return $date[0];
    }

    public static function getMonthStr($index)
    {
        $Mes = array(
        1=>'Janeiro',
        2=>'Fevereiro',
        3=>'Março',
        4=>'Abril',
        5=>'Maio',
        6=>'Junho',
        7=>'Julho',
        8=>'Agosto',
        9=>'Setembro',
        10=>'Outubro',
        11=>'Novembro',
        12=>'Dezembro'
        );

        return $Mes[$index];
    }

    public static function getDayStr(int $index)
    {
        $Dia = array(
        0=>'Domingo',
        1=>'Segunda-feira',
        2=>'Terça-feira',
        3=>'Quarta-feira',
        4=>'Quinta-feira',
        5=>'Sexta-feira',
        6=>'Sábado'
        );

        return $Dia[$index];
    }

    public static function getCurrentMonth()
    {
        return date('m');
    }

    public static function getCurrentYear()
    {
        return date('Y');
    }
}
