<?php
/**
 * representa os módulos no conceito do ack
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
namespace AckCore\Model;
use AckDb\ZF1\TableAbstract;
class Modules extends TableAbstract
{
    protected $_name = "ack_modulos";
    protected $_row = "\AckCore\Model\Module";

    const moduleName = "ack_modulos";
    const moduleId = 5;

    protected $colsNicks = array(
                                    "construcao" => "Módulo em construção",
                                    "titulo_pt" => "Título da Seção",
                                    "titulodestaque" => "Título de Destaque"
                                );

    /**
     * retorna um módulo à partir de seu nome
     * @param  [type] $name [description]
     * @return [type] [description]
     */
    public static function getFromName($name)
    {
        $modelName = get_called_class();
        $model = new $modelName;
        $result =  $model->toObject()->disableOnlyNotDeleted()->setOnlyAvailable(0)->get(array("modulo"=>$name));

        if (empty($result)) {
            $rowName = $model->getRowName();

            return new $rowName;
        } else if(is_array($result))
            $result = reset($result);

        return $result;
    }
}
