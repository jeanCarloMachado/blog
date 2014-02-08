<?php
/**
 * classe de autenticação legada do frameowrk System,
 * para as próximas versões do ack o esquema de autenticação
 * do zend 2 é preferível
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
namespace AckUsers\Auth;

use AckCore\Utils\Encryption;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
/**
 * authenticacao
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
abstract class Authenticator implements ServiceLocatorAwareInterface
{
    //------------------ ESSES 3 VALORES DEVEM SER SETADOS NAS CLASSES FILHAS -------------------------
    /**
    * coluna de login
    * @var string
    */
    protected $identityColumn = "email";
    /**
     * coluna de senha
     * @var string
     */
    protected $credentialColumn = "senha";
    /**
     * nome do arquivo da classe de usuario extendendo System_DB_Table
     * @var [type]
     */
    protected $userTableModel = "\AckUsers\Model\Users";
    //------------------ ESSES 3 VALORES DEVEM SER SETADOS NAS CLASSES FILHAS -------------------------
    /**
     * instancia da classe de usuario
     * @var [type]
     */
    protected $_user;

    public function __construct()
    {
        $this->_user = new $this->userTableModel;
        if(session_id() == '') session_start();
    }

    public function authenticateFromObject(\AckUsers\Model\User $user)
    {
        return $this->authenticate($user->getEmail()->getBruteVal(),$user->getSenha()->getBruteVal(),array("disableEncrypt"=>true));
    }

    /**
     * autentica o usuário no banco de dados
     * @param  [type] $login    [description]
     * @param  [type] $password [description]
     * @return [type] [description]
     */
    public function authenticate($login,$password,$params = null)
    {
        if(!isset($params["disableEncrypt"])) $password = \AckCore\Utils\Encryption::encrypt($password);

        $whereClausule = array(
                $this->identityColumn => $login,
                $this->credentialColumn => $password
        );

        $return = $this->_user->onlyAvailable()->get($whereClausule);

        if(is_array($return)) $return  = reset($return);

        //caso a pesquisa retorne se cria a sessao de autenticacao
        if (!empty($return)) {
            $_SESSION[Encryption::strong($this->_user->getTableName())]['auth']['isAuth'] = true;
            $_SESSION[Encryption::strong($this->_user->getTableName())]['auth']['user'] = ($return);
        }

        return $this->isAuth();
    }

    /**
     * testa se o usuario existe
     * @param  [type]  $login    [description]
     * @param  [type]  $password [description]
     * @return boolean [description]
     */
    public function hasUser($login,$password)
    {
        if (isset($login) && isset($password)) {
            $result = $this->_user->get(array($this->identityColumn=>$login, $this->credentialColumn=>\AckCore\Utils\Encryption::strong($password)));
            if(isset($result[0])) return true;

            return false;
        }
    }

    /**
     * seta o usuario
     * @param [type] $array [description]
     */
    public function setUser($array)
    {
        foreach ($array as $collumnName => $collumnValue) {
            $_SESSION[Encryption::strong($this->_user->getTableName())]['auth']['user'][$collumnName] =  $collumnValue;
        }
    }

    /**
     * pega o usuario
     * @return [type] [description]
     */
    public function getUser()
    {
        $index = Encryption::strong($this->_user->getTableName());

        if(isset($_SESSION[$index]['auth']['user'])) return ($_SESSION[$index]['auth']['user']);

        return null;
    }

    public function appendDataToUserSession($key,$data)
    {
        $index = Encryption::strong($this->_user->getTableName());

        $data = serialize($data);
        $_SESSION[$index][$key] = $data;

        return $this;
    }

    public function getDataFromUserSession($key)
    {
        $index = Encryption::strong($this->_user->getTableName());

        if(empty($_SESSION[$index][$key])) return null;

        $data = unserialize($_SESSION[$index][$key]);

        return $data;
    }

    /**
     * retorna o objeto usuário
     * @return [type] [description]
     */
    public function getUserObject()
    {
        if(!$this->isAuth()) throw new \Exception("Não há usuário autenticado neste contexto");

        return $this->_getUserObject();
    }

    protected function _getUserObject()
    {
        $resultUser = $this->getUser();
        if (is_array($resultUser)) {
            $return = $this->_user->toObject()->onlyAvailable()->get(array("id"=>$resultUser["id"]));
            $return = reset($return);

            return $return;

        } elseif (is_object($resultUser)) {
            return $resultUser;
        }

        throw new \Exception("a sessão do uusário não é nem um objeto nem umm array ( o sistema não sabe como proceder) ", 1);
    }

    /**
     * retorna o objeto usuário de uma maneira estática
     * @return [type] [description]
     */
    public static function getUserObjectStatic()
    {
        $class = (get_called_class());
        $obj = new $class();
        $result = $obj->getUserObject();

        return $result;
    }

    /**
     * testa se o usuario está autenticado
     * @return boolean [description]
     */
    public function isAuth()
    {
        if ($_SESSION[Encryption::strong($this->_user->getTableName())]['auth']['isAuth']) {

            // $moduleName = \AckCore\Facade::getCurrentModuleName();
            // \System\Debug\Debug::dg($moduleName);
            // //se o o módulo for do ack e o usuário não for do ack retorna falso
            // if (preg_match('/^.*Ack.*$/', $moduleName)) {
            // 	$this->logoff();
            // 	return false;
            // }
            return true;
        }

        return false;
    }

    /**
     * tira a autenticação do usuário
     * @return [type] [description]
     */
    public function logoff()
    {
        if (isset($_SESSION[Encryption::strong($this->_user->getTableName())])) {
            unset($_SESSION[Encryption::strong($this->_user->getTableName())]);

            return true;
        }

        return false;
    }

   //========================= getters and setters =========================
     /**
     * localizador de serivcos do zend
     *
     * @var Zend\SerivceLocator
     */
    protected $serviceLocator;
    /**
     * seta o localizador de servicos
     *
     * @param ServiceLocatorInterface $serviceLocator Zend\ServiceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    //======================= END getters and setters =======================
}
