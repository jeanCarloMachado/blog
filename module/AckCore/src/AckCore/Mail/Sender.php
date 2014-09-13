<?php
/**
 * enviador de email (padrão legado)
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
namespace AckCore\Mail;
class Sender
{
    private $destinatary;
    private $sender;
    private static $debug = false;

    public static function setDebug($status)
    {
        self::$debug = $status;
    }

    public static function getDebug()
    {
        return self::$debug;
    }

    public static function send($vars,$subject,$file=null,$destinatary=null,$sender=null)
    {
        $sm = new self;
        /**
         * se não foi passado o destinatário
         * pega o default da aplicacao
         */
<<<<<<< HEAD
         if(!$destinatary)
            throw new \Exception("O destinatário não foi passado");
=======
        if(!$destinatary) throw new \Exception("O destinatário não foi passado");
>>>>>>> SiteJean-master

        /**
         * se não foi passado o emissor
         * pega o default da aplicacao
         */
        $sender = ($sender) ? $sender : "contato@icub.com.br";
        /**
         * se não foi passado o caminho do arquivo
         * pega o default da aplicacao
         */
        if(!$file)
            throw new \Exception("O arquivo do email não foi passado");

        //Informações sobre quebra de linha para o Header do E-mail
        if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
        elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
        elseif(PHP_OS == "Darwin") $quebra_linha = "\n"; // Se for MacOS
        else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");

        //Define o cabeçalho do e-mail
        $headers = "MIME-Version: 1.1".$quebra_linha;
        $headers .= "Content-type: text/html; charset=utf-8".$quebra_linha;
        $headers .= "From: ".$sender.$quebra_linha;
        $headers .= "Return-Path: ".$sender.$quebra_linha;
        $headers .= "Reply-To: ".$sender.$quebra_linha;

        /**
         * envia o email
         */
        $content = self::loadMail($file,$vars);

        if (self::getDebug()) {
            \AckCore\Utils::dg($content);
        } else {
            if (is_array($destinatary)) {
                foreach ($destinatary as $value)
                    $result = mail($value, $subject,$content ,$headers);
            } else
                $result = mail($destinatary, $subject,$content , $headers);
        }

        return $result;
    }

    private static function loadMail($file,$vars = array())
    {
        ob_start(); // start buffer
            extract($vars);
            global $endereco_site;
            /**
             * adiciona o cabeçalho
             */
            include $file;
        $content = ob_get_contents(); // assign buffer contents to variable
        ob_end_clean(); // end buffer and remove buffer contents

        return $content;
    }
}
