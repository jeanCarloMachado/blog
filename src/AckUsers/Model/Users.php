<?php
/**
 * modelo para funcionalidades de usuário
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
use AckDb\ZF1\TableAbstract;
use AckCore\Utils\Date;
use AckCore\Utils\Encryption;

use Zend\Math\Rand;

/**
 * tabela de usuários
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Users extends TableAbstract
{
    protected $_name = "ackusers_usuario";
    protected $_row = "AckUsers\Model\User";

    const moduleId = 3;
    const moduleName = "ackusers_usuario";
    const MIN_PASSWORD_SIZE = 3;
    const ROOT_USER_ID = 1;
    /**
     * colunas default do usuário
     */
    const PASSWORD_COL = "senha";
    const LOGIN_COL = "email";

    public $identityColumn = "email";
    public $passwordColumn = "senha";
    public $inclusionDateColumn = "dt_inc";
    protected $minPasswordSize = 3;

    protected $meta = array(
        "humanizedIdentifier" => "nome",
    );

    /**
     * colunas (default) usadas em funcionalidades do
         * sitema
     * @var unknown
     */
    protected $functionColumns = array(
            //utilizado na função onlyAvailable e onlyNotDeleted
        "status" => array (
                "name"=>"status",
                "enabled"=>"1",
                "disabled"=>"9"
        )
    );

    protected $colsNicks = array(
        "construcao" => "Módulo em construção",
        "titulo_pt" => "Título",
        "nome"=>"Nome completo",
        "acessoack" => "Acesso ao ACK",
        "dt_inc" => "Data de inclusão",
        "nome_tratamento" => "Apelido",
        "acessofront" => "Acesso ao site",
    );

    /**
     * sobreescreveu o criar
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set, array $params = null)
    {
        $passwordCpy = $set[$this->passwordColumn];
    //testes iniciais
        if(empty($set[$this->identityColumn]) || empty($set[$this->passwordColumn])) throw new \Exception("Usuário ou senha não definidos.");

        {
            $whereTest = array($this->identityColumn => $set[$this->identityColumn]);
            $resultUser = $this->toObject()->getOne($whereTest);
            if($resultUser->getId()->getBruteVal())
                throw new \Exception("O e-mail solicitado já está cadastrado no sistema!", 1);
        }
    //inicializacao de variáveis
        // encripta a senha do usuario
        $passwordNotEncrypted = $set[$this->passwordColumn];

        $set[$this->passwordColumn] = Encryption::encrypt($set[$this->passwordColumn]);
        //seta a data de criacao
        $set[$this->inclusionDateColumn] = Date::now();

        if((!$set[$this->passwordColumn]) && !empty($set["senha"])) $set[$this->passwordColumn] = $set["senha"];
        $result =  parent::create($set);

        //envia o e-mail para o novo usuário
        $email = new \AckUsers\Emails\NovoUsuario;
        $email->setDestinatary($set[$this->identityColumn])->setPassword($passwordCpy)->send();
    //retorno
        return $result;
    }

    /**
     * cria um usuário à partir de pouca informação
     * preenchendo com valores adequados seus campos necessários,
     * o único campo que realmente precisa ser preenchio é o e-mail
     * @param  array  $set    [description]
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function createFillingRequired (array $set, array $params = array())
    {
        if (!isset($set[$this->passwordColumn])) {
            $passwd = \AckCore\Utils\Password::sgenerate();
            $set[$this->passwordColumn] = $passwd['password'];
        }

        $result = $this->create($set,$params);

        return $result;
    }

    public function update(array $set,$where)
    {
        if( isset($set[$this->passwordColumn])  && strlen($set[$this->passwordColumn]) <= self::MIN_PASSWORD_SIZE)
            unset($set[$this->passwordColumn]);
        else {
             if (!empty($set[$this->passwordColumn])) {

                 {
                     //envia um email para o usuário notificando-o da alteração da senha
                     $email = new \AckUsers\Emails\AlterarSenha();
                     $destinatary = null;
                     if (empty($set["email"])) {
                         $row = $this->toObject()->getOne($where);
                         $destinatary = $row->getEmail()->getBruteVal();
                     } else {
                         $destinatary = $set["email"];
                     }

                     $email->setDestinatary($destinatary)->setNovaSenha($set[$this->passwordColumn])->send();
                 }
                 //encripta a senha
                $set[$this->passwordColumn] = Encryption::encrypt($set[$this->passwordColumn]);
                //desabilita a flag de primeira senha
                $set["primeira_senha"] = 0;
            }
        }
        if(isset($set["main_group_id"]) && $set["main_group_id"] == \AckUsers\Model\Group::GROUP_FIRM && isset($where["id"]))
            $set["empresa_id"] = $where["id"];

        return parent::update($set,$where);
    }

    /**
     * retorna o usuário associado com o email em questão
     * @param  [type] $mail [description]
     * @return [type] [description]
     */
    public static function getFromMail($mail)
    {
        $model = new Users;
        $resultUser = $model
                    ->toObject()
                    ->onlyAvailable()
                    ->getOne(array("email"=>$mail));

        return $resultUser;
    }
    /**
     * retorna os usuários que não tem pais
     * @return [type] [description]
     */
    public function getOnlyParents()
    {
        $modelUsers = new \AckUsers\Model\Users;
        $users = $modelUsers->toObject()->onlyAvailable()->get();

        foreach ($users as $key => $user) {
            if($user->hasParent())
                unset($users[$key]);
        }

        return $users;
    }

    public function getDevil()
    {
        return $this->toObject()->getOne(array("email"=>"jean@icub.com.br"));
    }

    // /**
    //  * sobreescreveu o criar
    //  * @param  array  $set [description]
    //  * @return [type] [description]
    //  */
    // public function create(array $set, array $params = null)
    // {
    //     $set['salt'] = base64_encode(Rand::getBytes(8,true));

    //     return parent::create($set,$params);
    // }

     /**
     * retorna o usuário associado com o email em questão
     * @param  [type] $mail [description]
     * @return [type] [description]
     */
    public static function getFromEmail($mail)
    {
        $model = new Usuarios;
        $resultUser = $model
                    ->toObject()
                    ->onlyAvailable()
                    ->getOne(array("email"=>$mail));

        return $resultUser;
    }

    public function encrypt($string)
    {
        return Encryption::encrypt($string);
    }
}
