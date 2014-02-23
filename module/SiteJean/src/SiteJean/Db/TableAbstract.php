<?php
/**
 * sobreescreve a tabela abstrata para
 * incrementar com funcionalidades
 * automáticas de filtro de empresas
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
 * @Author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace SiteJean\Db;

use AckDb\ZF1\TableAbstract as AckTableAbstract;
/**
 * sobreescreve a tabela abstrata para
 * incrementar com funcionalidades
 * automáticas de filtro de empresas
 *
 * @category Business
 * @package  AckDefault
 * @Author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class TableAbstract extends AckTableAbstract
{

     /**
     * faz a consulta ao banco de dados
     * @param  [type] $array  [description]
     * @param  [type] $params [description]
     * @return [type] [description]
     */
    public function get(array $where=null,$params=null,$columns=null)
    {
        //adiciona a empresa ao filtro caso seja um usuário de alguma
        if ($this->getServiceLocator()->get('Auth')->hasIdentity()) {
            $user =  $this->getServiceLocator()->get('Auth')->getIdentity();

            if ((!isset($where['filial_id'])
                || empty($set['filial_id']))
                && $user->getFilialId()->getBruteVal()) {
                $where['filial_id'] = $user->getFilialId()->getBruteVal();
            }
        }

        return parent::get($where, $params, $columns);
    }

     /**
     * cria uma linha no banco de dados recebendo um
     * array com suas colunas
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set,array $params=null)
    {

         //adiciona a empresa ao filtro caso seja um usuário de alguma
        if ($this->getServiceLocator()->get('Auth')->hasIdentity()) {
            $user =  $this->getServiceLocator()->get('Auth')->getIdentity();

            if ((!isset($set['filial_id']) || empty($set['filial_id'])) && $user->getFilialId()->getBruteVal()) {
                $set['filial_id'] = $user->getFilialId()->getBruteVal();
            }
        }

        return parent::create($set, $params);
    }
}
