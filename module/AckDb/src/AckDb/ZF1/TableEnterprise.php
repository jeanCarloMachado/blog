<?php
/**
 * adiciona o contexto empresa a uma tabela populando todas
 * seus SQL's com a coluna empresa_id para que a correta filtragem aconteça de maneira
 * automática
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
namespace AckDb\ZF1;
use AckDb\ZF1\TableAbstract as Table;
abstract class TableEnterprise extends Table
{
    //###################################################################################
    //################################# sqls para o usuário ###########################################
    //###################################################################################
    /**
     * faz a consulta ao banco de dados
     * @param  [type] $array  [description]
     * @param  [type] $params [description]
     * @return [type] [description]
     */
    public function get(array $where=null,$params=null,$columns=null)
    {
        $firmId = \AckCore\Facade::getCurrentUser()->getEmpresaId()->getBruteVal();
        if($firmId)
            $where["empresa_id"] = $firmId;

        return parent::get($where,$params,$columns);
    }

    /**
     * cria uma linha no banco de dados recebendo um
     * array com suas colunas
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set)
    {
        $firmId = \AckCore\Facade::getCurrentUser()->getEmpresaId()->getBruteVal();
        if($firmId)
            $set["empresa_id"] = $firmId;

        return parent::create($set);
    }
    //###################################################################################
    //################################# END sqls para o usuário ########################################
    //###################################################################################
}
