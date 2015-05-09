<?php
/**
 * modelo de sistema
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
class Systems extends TableAbstract
{
    protected $_name = "ack_sistema";
    protected $_row = "\AckCore\Model\System";
    const moduleName = "geral_ack";
    const moduleId = 1;

    protected $colsNicks = array(
                                    "nome_site" => "Nome do Site",
                                    "email" => "E-mail",
                                );

    public function getMaxItens()
    {
        $result = $this->run("SELECT itens_pagina FROM $this->_name");
        $result = reset($result);

        return $result['itens_pagina'];
    }
    /**
     * retorna o sistema principal do software (DEPRECATED)
     * @return [type] [description]
     */
    public static function getMainSystem()
    {
        $model = new Systems;
        $result = $model->toObject()->getOne(array("id"=>1));

        return $result;
    }
    /**
     * retorna a entrada do sistema atualmente rodando
     * @return [type] [description]
     */
    public static function getCurrent()
    {
        $model = new Systems;
        $result = $model->toObject()->getOne(array("id"=>1));

        return $result;
    }
}
