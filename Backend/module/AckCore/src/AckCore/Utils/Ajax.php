<?php
/**
 * funções de ajax e também se comporta como um container para retorno de ajax
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
use \AckCore\ExtendedObject;
class Ajax extends ExtendedObject
{
    public function __construct(array &$variables = null)
    {
        $this->vars = $variables;
    }

    public function toArray()
    {
        return $this->vars;
    }
    /**
     * simula o retorno do ajax mas continua a execução
     * @param  [type] $response [description]
     * @return [type] [description]
     */
    public static function simulateReturn($response)
    {
        //configurações
        apache_setenv('no-gzip', 1);
        ini_set('zlib.output_compression', 0);
        ob_end_clean();
        header("Connection: close");
        ignore_user_abort(true);
        ob_start();
        echo $response;
        header("Content-Length: " . mb_strlen($response));
        ob_end_flush();
        flush();

        return true;
    }

    public function notifyStatus($mainResult,$falseMessage = null,$trueMessage = null)
    {
        $trueMessage = ($trueMessage) ? $trueMessage : "Sucesso na operação!";
        $falseMessage = ($falseMessage) ? $falseMessage :  "Ocorreu algum problema na operação, por favor tente novamente.";

        if (is_array($mainResult) && !empty($mainResult)) {
            echo json_encode($mainResult);
        } elseif ($mainResult) {

            echo json_encode(array(
                        "status" => 1,
                        "mensagem" => $trueMessage ,
                        ));
        } else {
            echo json_encode(array(
                    "status" => 0,
                    "mensagem" => $falseMessage ,
                    ));

        }
    }

    /**
     * notifica o fim da execuçao e o resultado obtido;
     * @param  [type] $mainResult [description]
     * @return [type] [description]
     */
    public static function notifyEnd($mainResult,$falseMessage = null,$trueMessage = null)
    {
        $trueMessage = ($trueMessage) ? $trueMessage : "Sucesso na operação!";
        $falseMessage = ($falseMessage) ? $falseMessage :  "Ocorreu algum problema na operação, por favor tente novamente.";

        if (is_array($mainResult) && !empty($mainResult)) {
            echo json_encode($mainResult);
            die;
        }

         if ($mainResult) {
            echo json_encode(array(
                        "status" => 1,
                        "mensagem" => $trueMessage ,
                        ));
            die;
        }
        echo json_encode(array(
                    "status" => 0,
                    "mensagem" => $falseMessage ,
                    ));
        die;
    }

    /**
     * extrai os dados de uma array de ajax
     * @param  array  $variables [description]
     * @return [type] [description]
     */
    public static function extractData(array $variables)
    {
        $variables = \AckCore\Utils\Arr::getOneLevelArray($variables);

        return $variables;
    }
}
