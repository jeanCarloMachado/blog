<?php
/**
 * trait para gerenciamento de usuários
 * autenticados no sistema
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
namespace AckUsers\Model\Traits;

use AckUsers\Emails\AlterarSenha;
use AckCore\Utils\Password;

trait AuthenticatedRowModel
{
    protected $tableModel;
    protected $identifyColumn = ''

    /**
     * altera a senha de um usuário
     *
     * @param string $currentPassword
     * @param string $newPassoword
     * @param string $newPasswordCpy
     *
     * @return boolean
     */
    public function changePassword($currentPassword, $newPassword, $newPasswordCpy = null)
    {
        if (!($newPassword == $newPasswordCpy) && $newPasswordCpy) {
            throw new \Exception('As novas senhas não conferem', 1);
        }

        if ($this->getSenha()->getBruteVal() != $this->encrypt($currentPassword)) {
            throw new \Exception("A senha antiga não confere.", 1);
        }
        if ($newPassword == $currentPassword) {
            throw new \Exception('A senha é a mesma.', 1);
        }

        $set = array('senha'=>$this->encrypt($newPassword));
        $where = array('id'=>$this->getId()->getBruteVal());

        $email = new AlterarSenha;
        $email->setNovaSenha($newPassword)
            ->setDestinatary($this->getLoggedUser()->getEmail()->getBruteVal())
            ->send();

        $result =  $this->getTableInstance()
            ->update(
                $set,
                $where
            );

        return $result;
    }

    /**
     * recupera a senha de um usuário
     *
     * @param string $newPasswordCpy
     *
     * @return boolean
     */
    public function retrievePassword()
    {
        $newPassword = Password::generate();

        $set = array('senha'=>$this->encrypt($newPassword));
        $where = array('id'=>$this->getId()->getBruteVal());

        $email = new RecuperarSenha;
        $email->setNovaSenha($newPassword)
            ->setDestinatary($this->getLoggedUser()->getEmail()->getBruteVal())
            ->send();

        $result =  $this->getTableInstance()
            ->update(
                $set,
                $where
            );

        return $result;
    }

    /**
     * Gets the value of loggedUser.
     *
     * @return mixed
     */
    public function getLoggedUser()
    {
        return $this->loggedUser;
    }

    /**
     * Sets the value of loggedUser.
     *
     * @param mixed $loggedUser the logged user
     *
     * @return self
     */
    public function setLoggedUser($loggedUser)
    {
        $this->loggedUser = $loggedUser;

        return $this;
    }

    /**
     * retorna a mensagem de último acesso do usuário
     * @return [type] [description]
     */
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
}
