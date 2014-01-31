<?php
namespace AckUsers\Model;

use \AckCore\Utils\Password;
class Usuario extends User
{
    protected $_table = "\AckUsers\Model\Usuarios";

    /**
     * reseta a senha do usuário
     * @return Ambigous <string>
     */
    public function resetPassword()
    {
        $set = array();
        $generated = Password::sgenerate();

        $modelTableName = $this->_table;
        $modelUsers = new $modelTableName;
        $passCol = $modelUsers->passwordColumn;
        $set[$passCol] = $generated["password"];

        $where = array("id"=>$this->getId()->getBruteVal());

        $model = $this->getTableInstance();
        $result = $model->update($set,
                $where);

        return $generated["password"];
    }
}
