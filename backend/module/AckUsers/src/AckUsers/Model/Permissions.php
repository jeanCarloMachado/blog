<?php
namespace AckUsers\Model;
use AckDb\ZF1\TableAbstract;
use Ackusers\Model\Permissions;
class Permissions extends TableAbstract
{
    protected $_name = "ack_permissoes";
    protected $_row = "\AckUsers\Model\Permission";

    /**
     * este modelo tem o mesmo esquema de permissões do de usuário
     */
    const moduleId = 3;
    const moduleName = "usuarios_ack";

    /**
     * retorna a permissão do módulo a partir de
     * um obetodo do tipo coluna
     * @return [type] [description]
     */
    public static function getPermissionFromColumnObject(\AckCore\Vars\Variable $columObj,$user)
    {
        $modelName = $columObj->getTable();

        if(!defined("$modelName::moduleId")) return (new Permission)->setNivel(2)->setModulo(1)->setUsuario($user->getId()->getBruteVal());

        $moduleId = $modelName::moduleId;
        $permissions = new Permissions;

        $where = array("modulo"=>$moduleId,"usuario"=>$user->getId()->getBruteVal());
        $result = $permissions->toObject()->getOne($where);

        if(empty($result)) return new Permission;

        return $result;
    }

    public function savePermissionsBlock($array)
    {
        $this->attach("AckCore\Log\Observer\DbLog");

        foreach ($array["permissao"] as $moduleId => $permissionLevel) {
            $set = array("nivel"=>$permissionLevel,"usuario"=>$array["id"],"modulo"=>$moduleId);
            $where = array("usuario"=>$array["id"],"modulo"=>$moduleId);
            $result = $this->updateOrCreate($set,$where);
        }
        $userId  = $array["id"];

        $modelUusarioConfiguracoes = new \AckUsers\Model\UsuarioConfiguracoes;
        $configuracaoDeUsuario = $modelUusarioConfiguracoes->toObject()->onlyAvailable()->getOne(array("usuario_id"=>$userId));
        if(!$configuracaoDeUsuario->getId()->getBruteVal()) throw new \Exception("Não foi possível encontrar uma entrada de configuração para este usuário.", 1);

        $configuracaoDeUsuario->setMainMenuCache(null)->save();

        return $result;
    }
}
