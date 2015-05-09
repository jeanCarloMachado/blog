<?php
/**
 * modelo de abstração de tabela representando  a tabela endereços
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
namespace AckLocale\Model;
use AckDb\ZF1\TableAbstract;
class Addresses extends TableAbstract
{
    /**
     * nome da tabela no banco de dados
     * @var string
     */
    protected $_name = 'ack_enderecos';
    protected $_row = "\AckLocale\Model\Address";

    const DEFAULT_SYSTEM_ID = 1;
    const moduleName = "enderecos";
    const moduleId = 16;

    protected $colsNicks = array(
        "nome_pt" => "Nome",
        "descricao_pt" => "Descrição",
        "fone_pt" => "Fone",
        "email_pt" => "E-mail",
        "fone2_pt" => "Fone 2",
        "endereco_pt" => "Endereço",
        "cidade_pt" => "Cidade",
        "bairro_pt" => "Bairro",
        "estado_pt" => "Estado",
        "pais_pt"=>"País",
        "link_mapa_pt" => "Mapa",
        "horario_atendimento" => "Horário de atendimento",
        "cep_pt" => "CEP",
        "visivel"=>"Visível",
    );

    /**
     * retorna o endereço default do sistema
     * @return [type] [description]
     */
    public static function getDefault()
    {
        $model = new Addresses;
        $result = $model->getFirst();

        return $result;
    }
}
