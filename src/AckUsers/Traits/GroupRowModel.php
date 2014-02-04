<?php
/**
 * funcionalidades de grupo para modelo de usuario - linha
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
namespace AckUsers\Traits;
/**
 * funcionalidade para módulo de linha de usuário
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class GroupRowModel
{
    /**
     * testa se o usuário está em um grupo qualquer da relação nn
     * @param  [type] $groupIdentifier [description]
     * @return [type] [description]
     */
    public function inGroup($groupIdentifier)
    {
        //testa pelo id do grupo
        if (is_int($groupIdentifier)) {

            $modelUsersGroups = new \AckUsers\Model\UsersGroups;
            $UsersGroups = $modelUsersGroups->get(array("usuario_id"=>$this->getId()->getBruteVal(),"grupo_id"=>$groupIdentifier));
            if(!empty($UsersGroups))

                return true;
        }

        return false;
    }
    /**
     * testa se o grupo passado é o grupo principal do usuário
     * @param  [type]  $groupId [description]
     * @return boolean [description]
     */
    public function isMyMainGroup($groupId)
    {
        if($this->getMainGroupId()->getBruteVal() == $groupId) return true;

        return false;
    }

    /**
     * testa se o usuário tem a permissão deste grupo ou de algum
     * que englobe este
     * @param  [type]  $groupId [description]
     * @return boolean [description]
     */
    public function hasGroupPermission($groupId)
    {
        if($this->isMyMainGroup($groupId)) return true;

        $groups = $this->getMyMainGroup()->getMyChildGroups();
        foreach ($groups as $group) {
            if($group->getSlaveId()->getBruteVal() == $groupId) return true;
        }

        return false;
    }

    public function amIResponsableFor(\AckDb\ZF1\RowAbstract $row)
    {
        if($this->isMe($row)) return true;
        //testa casos de hierarquia
        //
        $modelUsers = new Users;
        $object = $modelUsers->toObject()->onlyAvailable()->get(array("empresa_id"=>$this->getId()->getBruteVal(),"id"=>$row->getId()->getBruteVal()));
        if(!empty($object))

            return true;

        return false;
    }
    /**
     * retorna o objeto representando o
     * grupo principal do usuário
     * @return [type] [description]
     */
    public function getMyMainGroup()
    {
        $result = null;
        $gId = $this->getMainGroupId()->getBruteVal();
        if(empty($gId))

            return new Group;

        $result = Groups::getFromId($gId);

        return $result;
    }
}
