<?php
/**
 * modelo de usuário, contém todas as informações e funcionalidades cabíveis
 * a um usuário do sistema, os usuário atutenticados também são instancias
 * desta classe.
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
namespace AckUsers\Model;
use AckDb\ZF1\RowAbstract,
    AckCore\Interfaces\Cacheable,
    AckUsers\Model\Permissions,
    AckUsers\Model\Photos;
class User extends RowAbstract implements Cacheable
{
    protected $_table = "AckUsers\Model\Users";
    protected $cache = array();
    const ROOT_USER_ID = 1;

    /**
     * retorna verdadeiro se o objeto passao é exatamente o
     * mesmo que o usuário
     * @param  SystemDbRowAbstract $row [description]
     * @return boolean             [description]
     */
    public function isMe(\AckDb\ZF1\RowAbstract &$row)
    {
        if($row->getId()->getBruteVal() == $this->getId()->getBruteVal()) return true;

        return false;
    }

    /**
     * retorna o nível de permissão de um usuário para com um módulo
     * @param  [type] $moduleId [description]
     * @return [type] [description]
     */
    public function permissonLevelOfModule($moduleId)
    {
        if(!$moduleId)
            throw new Excpetion("o id do módulo é obrigatório");

        $modelPermission = new Permissions;

        $where = array("usuario"=>$this->getId()->getBruteVal(),"modulo"=>$moduleId);
        $result = $modelPermission->toObject()->get($where);
        $result = reset($result);

        if(empty($result))

            return 0;

        return $result->getNivel()->getBruteVal();
    }
    /**
     * testa se o usuário tem permissão ao módulo
     * @param  [type]  $moduleId [description]
     * @return boolean [description]
     */
    public function hasModulePermission($moduleId)
    {
        if($this->permissonLevelOfModule($moduleId)) return true;

        return false;
    }
    /**
     * removo o avatar de um usuário
     * @return [type] [description]
     */
    public function removeAvatar()
    {
        $set = array("profile_image_id"=>0);
        $model = new Users();
        $result = $model->update($set,array("id"=>$this->getId()->getBruteVal()));

        return (!empty($result)) ? 1 : 0;
    }

    public function addAvatar($file,$title)
    {
        $where = array(
                    "relacao_id"=>$this->getId()->getBruteVal(),
                    "modulo"=>Users::avatarId
                );
        $set = $where;
        $set["arquivo"] = $file;
        $set["titulo_pt"] = $title;

        $validate = new Validate;
        $validate->rNonEmpty($set);

        //cria a imagem
        $modelImage = new Photos();

        $resultSet = $modelImage->updateOrCreate($set,$where);

        if(empty($resultSet))

            return false;

        $profileImageId = $this->getProfileImageId()->getBruteVal();

        //se ainda não tem uma imagem de perfil a cria
        if (empty($profileImageId)) {

            $fotoId = reset($resultSet);
            //se ainda for um array então efetua mais
            //um reset
            if(is_array($fotoId))
                $fotoId = reset($fotoId);

            $set = array("profile_image_id"=>$fotoId);
            $where = array("id"=>$this->getId()->getBruteVal());

            $model = new Users();
            $resultUpdate = $model->update($set,$where);
        }

        return true;
    }

    /**
     * recupera a senha do usuário
     * @return [type] [description]
     */
    public function retrievePassword()
    {

    }

    /**
     * reseta a senha do usuário
     * @return Ambigous <string>
     */
    public function resetPassword()
    {
        $set = array();
        $generated = \AckCore\Utils\Password::sgenerate();

        $modelTableName = $this->_table;
        $modelUsers = new $modelTableName;
        $passCol = $modelUsers->passwordColumn;
        $set[$passCol] = $generated["password"];

        $where = array("id"=>$this->getId()->getBruteVal());

        $model = new \AckUsers\Model\Users;

        $result = $model->update($set,$where);

        return $generated["password"];
    }

    /**
     * retorna o próximo usuário
     * @return [type] [description]
     */
    public function getNext($where = array())
    {

        $modelUsers = new \AckUsers\Model\Users;

        $whereBelowUsers = $where;
        $whereBelowUsers["id >"] = ($this->getId()->getBruteVal()) ? $this->getId()->getBruteVal() : 0;

        $user = $modelUsers->toObject()->onlyAvailable()->getOne($whereBelowUsers,array("limit"=>array("count"=>1)));

        if(empty($user)) $user = $modelUsers->toObject()->onlyAvailable()->getOne($where,array("limit"=>array("count"=>1)));

        return $user;
    }
    /**
     * retorna os pais de um usuário (guarda cache também)
     * @return [type] [description]
     */
    public function getParents()
    {
        $cache = $this->getCacheBYKey(__FUNCTION__);

        if(!empty($cache)) return $cache;

        $modelUsersHierarchys = new \AckUsers\Model\UsersHierarchys;
        $parents = $modelUsersHierarchys->toObject()->get(array("slave_id"=>$this->getId()->getBruteVal()));

        $this->setCacheEntry(__FUNCTION__,$parents);

        return $parents;
    }
    /**
     * retorna  os filhos na hierarquia de um usuário
     * @return [type] [description]
     */
    public function getChild()
    {
        throw new \Exception("Função não implemetada ".__FUNCTION__, 1);
    }

    public function hasParent()
    {
        $parents = $this->getParents();
        if(empty($parents))

            return false;

        return true;
    }

    public function getCacheByKey($key)
    {
        return $this->cache[$key];
    }

    public function setCacheEntry($key,$value)
    {
        $this->cache[$key] = $value;

        return $this;
    }

    public function getApelido()
    {
        return $this->getNome();
    }

    public function getLastAcessMessage()
    {
        $result = null;

        $accessDate = $this->getUltimoAcesso()->getBruteVal();
        if (empty($accessDate)) {
            $result="este é o seu primeiro acesso";
        } else {
            $data=\AckCore\Utils\Number::convertDate($this->getUltimoAcesso()->getBruteVal(), "%d de REPLACEMONTH de %Y às %Hh%M");
            $month = explode("-",$this->getUltimoAcesso()->getBruteVal());
            $month = (int) $month[1];
            $str = \AckCore\Utils\Date::getMonthStr($month);
            $data = str_replace("REPLACEMONTH", $str,$data);
            $result="seu último acesso foi no dia ".$data;
        }

        return $result;
    }
    //###################################################################################
    //################################# empresa ###########################################
    //###################################################################################

    //###################################################################################
    //################################# END empresa ########################################
    //###################################################################################
    //###################################################################################
    //################################# grupos ###########################################
    //###################################################################################
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

    //###################################################################################
    //################################# END grupos ########################################
    //###################################################################################
}
