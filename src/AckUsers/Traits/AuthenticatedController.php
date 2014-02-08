<?php
/**
 * trait para controllers de usuários com
 * actions de login/logout, alterar senha, recuperar senha, etc
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

use AckUsers\Form\Login as LoginForm;
use AckUsers\Form\Cadastro as CadastroForm;

trait AuthenticatedController
{
    /**
     * perfil do usuário
     * @return [type] [description]
     */
    public function perfilAction()
    {
        /** @var auth  */
        $auth = $this->getServiceLocator()->get('auth');

        if (!$auth->isAuth()) {
            $this->redirect()->toRoute('login');
        }

        $this->getEvent()->getRouteMatch()->setParam('id',Facade::getCurrentUser()->getId()->getBruteVal());
        $this->getEvent()->getRouteMatch()->setParam('action','editar');

        $result =  parent::editarAction();

        return $result;
    }

     /**
    * trata do login do usuário
    *
    * @return viewModel parametros para a veiw
    */
    public function loginAction()
    {
        $auth = $this->getServiceLocator()->get('auth');

        //testa se o usuário já não está autenticado
        if ($auth->isAuth()) {
            $this->redirect()->toRoute('dashboard');
        }

        $formLogin = new LoginForm;
        $formCadastro = new CadastroForm;

        $vars = array();

        if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->getPost('login')) {

                $formLogin->setData($this->getRequest()->getPost());
                if ($formLogin->isValid()) {
                    $data = \AckCore\Utils\Arr::getOneLevelArray($formLogin->getData());

                    if ($auth->authenticate($data['email'], $data['senha'])) {
                        $this->redirect()->toRoute('dashboard');
                    } else {
                        $this->getServiceLocator()->get('notify')->error("Usuário ou senha incorretos.");
                    }
                } else {

                    $this->getServiceLocator()->get('notify')->error($formLogin->getMessages());
                }

            } elseif ($this->getRequest()->getPost('create')) {

                $formCadastro->setData($this->getRequest()->getPost());
                if ($formCadastro->isValid()) {
                    $model = new Usuarios;
                    try {
                        $result =  $model->toObject()->create(\AckCore\Utils\Arr::getOneLevelArray($formCadastro->getData()));

                        if (empty($result)) {
                            $this->getServiceLocator()->get('notify')->error("Não foi possível criar o usuário");
                        } else {

                            $auth = $this->getServiceLocator()->get('auth');
                            if($auth->authenticateFromObject($result)) $this->redirect()->toRoute("perfil-usuario");

                            $this->getServiceLocator()->get('notify')->success("Usuário cadastrado com sucesso! Efetue login para entrar");
                        }
                    } catch (\Exception $e) {
                       $this->getServiceLocator()->get('notify')->error($e->getMessage());
                    }
                }
            } else {
                $this->getServiceLocator()->get('notify')->notice("Nenhuma ação realizada.");
            }
        }

        $vars["formLogin"] = $formLogin;
        $vars["messages"] = $messages;
        $vars["formCadastro"] = $formCadastro;
        $this->viewModel->setVariables($vars);

        return $this->viewModel;
    }

    /**
     * trata da recuperação de senhas do usuário
     * @return [type] [description]
     */
    public function recuperarsenhaAction()
    {
        $formRecuperarSenha = new RecuperarSenhaForm;
         if ($this->getRequest()->isPost('recuperarsenha')) {

            $formRecuperarSenha->setData($this->getRequest()->getPost());
            if ($formRecuperarSenha->isValid()) {
                $data = $formRecuperarSenha->getData();
                $email = $data['email'];

                    $user = Usuarios::getFromEmail($email);

                    if ($user->getId()->getBruteVal()) {
                        $password = $user->resetPassword();
                        $destinatary = $user->getEmail()->getVal();

                        $result = \AckUsers\Emails\RecuperarSenha::getInstance()
                        ->setDestinatary($destinatary)
                        ->setUsuario($user->getNome()->getVal())
                        ->setNovaSenha($password)
                        ->send();

                        if ($result) {
                           $this->getServiceLocator()->get('notify')->error("Enviamos um e-mail para você!");
                        } else {
                            $this->getServiceLocator()->get('notify')->error("Não foi possível enviar o e-mail.");
                        }
                    } else {
                        $this->getServiceLocator()->get('notify')->error("Este usuário não existe");
                    }
            }
        }
        $vars = array();
        $vars["recuperarSenhaForm"] = $formRecuperarSenha;
        $this->viewModel->setVariables($vars);

        return $this->viewModel;
    }

    public function logoffAction()
    {
        $this->viewModel->setTerminal(true);

        /** @var auth  */
        $auth =$this->getServiceLocator()->get('auth');
        $auth->logoff();
        $this->redirect()->toRoute("home");

        return false;
    }

    /**
    * trata do login do usuário
    * @return [type] [description]
    */
    public function alterarsenhaAction()
    {
        $formAlterarSenha = new AlterarSenhaForm;
        $vars = array();

        if ($this->getRequest()->isPost()) {

//========================= alterar a senha =========================

            if ($this->getRequest()->getPost("salvarSenha")) {
                $formAlterarSenha->setData($this->getRequest()->getPost());

                if ($formAlterarSenha->isValid()) {

                }

//======================= END alterar a senha =======================
            } else {
                $this->getServiceLocator()->get('notify')->notice("Nenhuma ação realizada.");
            }
        }
        $vars["messages"] = $messages;
        $vars["formAlterarSenha"] = $formAlterarSenha;
        $this->viewModel->setVariables($vars);

        return $this->viewModel;
    }
}
