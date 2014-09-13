<?php
/**
 * funcionalidades para a linha de comando
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

namespace AckCore\Utils;
class Cmd
{
    /**
     * faz uma pergunta que admite somente verdadeiro ou falso
     * @param  [type]  $question   [description]
     * @param  boolean $defaultVal [description]
     * @return [type]  [description]
     */
    public static function booleanQuestion($question,$defaultVal = true)
    {
        $defaultStr = ($defaultVal) ? "y" : "n";
        echo $question."\n [y,n] Default ($defaultStr): ";
        $anwser = fgets(STDIN);
        \AckCore\Utils\String::sanitize($anwser);
        $anwser = (!($anwser)) ? $defaultStr : $anwser ;
        $anwser = strtolower($anwser);
        if ($anwser == "y") {
            return true;
        }

        return false;
    }

    /**
     * interage com o susuário de alguma forma
     * manda uma mensagem e espera uma saída
     * @param  [type] $message       [description]
     * @param  [type] $defaultReturn [description]
     * @return [type] [description]
     */
    public static function interact($message,$defaultReturn = null)
    {
        echo $message,PHP_EOL;

        if (!empty($defaultReturn)) {
            echo 'Default:',$defaultReturn,PHP_EOL;
        }

        $anwser = fgets(STDIN);
        \AckCore\Utils\String::sanitize($anwser);

        if(!$anwser) return $defaultReturn;

        return $anwser;
    }

    /**
     * mostra uma mensagem no terminal
     * usar ao invés do echo
     * @param  [type] $str [description]
     * @return [type] [description]
     */
    public static function show($str)
    {
        echo $str."\n";
    }

    /**
     * sai  do processo apresentando uma mensagem para o usuario
     * @param  string  $outputMessage [description]
     * @param  integer $status        [description]
     * @return [type]  [description]
     */
    public static function out($outputMessage = "",$status=1)
    {
        $message = "Saindo";
        if (!empty($outputMessage)) {
            $message.= "... mensagem: $outputMessage";
            self::show($message);
        }
        exit($status);
    }
}
