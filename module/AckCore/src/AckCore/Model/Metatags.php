<?php
/**
 * modelo de metatags
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

class Metatags extends TableAbstract
{
    const DEFAULT_SYSTEM_META_ID = 1;

    /**
     * nome da tabela no banco de dados
     * @var string
     */
    protected $_name = "ack_metatags";

    /**
     * nome da classe simbolizando uma linha (deve estender System_Row_Abstract)
     * @var string
     */
    protected $_row = "\AckCore\Model\Metatag";

    /**
     * constantes de módulo da classe, todo o modelo representa um módulo no
     * ack, por questões de desempenho e de funcionalidades internas esses campos
     * devem ser preenchidos manualmente
     */
    const moduleName = "metatags_ack";
    const moduleId = 2;

    public static function getDefault()
    {
        throw new \Exception("funcionalidade não implementada!", 1);
    }

    /**
     * cria uma linha no banco de dados recebendo um
     * array com suas colunas
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set,array $params=null)
    {
        if(!isset($set["modulo"]) || !isset($set['relacao_id'])) throw new \Exception("Dados essenciais não informados na criação da metatag!");

        $searchEquivalent = $this->get(array("modulo"=>$set["modulo"],"relacao_id"=>$set["relacao_id"]));

        if(!empty($searchEquivalent)) throw new \Exception("Metatag equivalente já existente!");

        return parent::create($set,$params);
    }
}
