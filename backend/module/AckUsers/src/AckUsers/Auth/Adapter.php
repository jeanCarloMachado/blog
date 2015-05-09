<?php
/**
 * adaptador no padrão zf2 para efetura a autenticaçao
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

namespace AckUsers\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AckUsers\Auth\Result as AckAuthResult;
/**
 * adaptador no padrão zf2 para efetura a autenticaçao
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Adapter implements AdapterInterface, ServiceLocatorAwareInterface
{
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
    //por default este serviço esta registrado no módulo
    //de ackUsers
    protected $authServiceName = "AckAuthenticationModel";
    protected $username = "";
    protected $password = "";
    protected $serviceLocator;

    /**
     * recebe usuário e senha para a autenticação,
     * autentica e guarda o valor
     *
     * @param string $username dados de autenticação
     * @param string $password dados de autenticação
     *
     *
     * @return void null description
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *                                                                   If authentication cannot be performed
     */
    public function authenticate()
    {
        $model = $this->getServiceLocator()->get($this->authServiceName);

        $whereClausule = array(
                $this->identityColumn => $this->getUsername(),
                $this->credentialColumn => $model->encrypt($this->getPassword())
        );

        $resultEntity = $model->toObject()->getOne($whereClausule);

        if ($resultEntity->getId()->getBruteVal()) {

            $ackAuthResult = new AckAuthResult(AckAuthResult::SUCCESS, $resultEntity);
        } else {
            $ackAuthResult = new AckAuthResult(AckAuthResult::FAILURE_CREDENTIAL_INVALID, $resultEntity);
        }

        return $ackAuthResult;
    }

    /**
     * passa-se um array de dados para o
     * adaptador e este descobre os equivalentes
     *
     * @param array $data dados
     */
    public function setData($data)
    {
        if (isset($data['email'])) {
            $this->username = $data['email'];
        }

        if (isset($data['senha'])) {
            $this->password = $data['senha'];
        }
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Gets the coluna de login.
     *
     * @return string
     */
    public function getIdentityColumn()
    {
        return $this->identityColumn;
    }

    /**
     * Sets the coluna de login.
     *
     * @param string $identityColumn the identity column
     *
     * @return self
     */
    public function setIdentityColumn($identityColumn)
    {
        $this->identityColumn = $identityColumn;

        return $this;
    }

    /**
     * Gets the coluna de senha.
     *
     * @return string
     */
    public function getCredentialColumn()
    {
        return $this->credentialColumn;
    }

    /**
     * Sets the coluna de senha.
     *
     * @param string $credentialColumn the credential column
     *
     * @return self
     */
    public function setCredentialColumn($credentialColumn)
    {
        $this->credentialColumn = $credentialColumn;

        return $this;
    }

    /**
     * Gets the value of authServiceName.
     *
     * @return mixed
     */
    public function getAuthServiceName()
    {
        return $this->authServiceName;
    }

    /**
     * Sets the value of authServiceName.
     *
     * @param mixed $authServiceName the auth service name
     *
     * @return self
     */
    public function setAuthServiceName($authServiceName)
    {
        $this->authServiceName = $authServiceName;

        return $this;
    }

    /**
     * Gets the value of username.
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the value of username.
     *
     * @param mixed $username the username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
