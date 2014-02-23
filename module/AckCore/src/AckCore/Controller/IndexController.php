<?php
/**
 * home do ack
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
namespace AckCore\Controller;
use AckUsers\Model\Users,
AckMvc\Controller\TableRowAutomatorAbstract,
AckCore\Facade;
class IndexController extends TableRowAutomatorAbstract
{
    //deixa os observers vazios
    protected $observers = array();
    /**
     * lista de controladores que o site pode direcionar
     * em caso de login com sucesso, estes serão testados
     * sucessivamente até que o sistema encontre um disponível
     * @var array
     */
    protected $redirectToOnSuccess = array(
        "\AckContent\Controller\DashboardController" => "/ack/dashboard",
        "\AckContent\Controller\TextosController" => "/ack/textos/ajuda",
        "\AckCore\Controller\Dadosgerais" => "/ack/dadosgerais/editar/1",
    );

    public function indexAction()
    {
        $auth = $this->getServiceLocator()->get('auth');

        if ($auth->isAuth()) {
            $this->redirect()->toRoute('ackHome');
        }

        $this->viewModel->setTerminal(true);

        return $this->viewModel;
    }

    /**
     * [loginAjax description]
     * @return [type] [description]
     */
    public function loginAjax()
    {
        $auth = $this->getServiceLocator()->get('auth');

        $user = $this->ajax["usuario"];
        $passwd = $this->ajax["senha"];

        if ($auth->authenticate($user,$passwd)) {

            $user = $auth->getUserObject();

            if (!$user->getAcessoAck()->getBruteVal()) {
                $auth->logoff();
                echo json_encode(array("status"=>0, "mensagem" => "Não foi possível efetuar login"));
                exit(0);
            }

            $user->setUltimoAcesso(\AckCore\Utils\Date::now())->save();

            foreach ($this->redirectToOnSuccess as $class => $path) {
                if(class_exists($class))
                    break;
            }

            echo json_encode(array("status"=>1,"mensagem"=>"Login efetuado com sucesso","url"=>$path));
            exit(1);
        } else {
            echo json_encode(array("status"=>0,"mensagem"=>"Não foi possível acessar seu cadastro!"));
            exit(1);
        }
    }

    /**
     * faz logoff
     *
     * @return void
     */
    public function logoffAction()
    {
        $auth = $this->getServiceLocator()->get('auth');

        $auth->logoff();

        $this->redirect()->toRoute('ackLogin');

    }

    public function rec_senhaAjax()
    {
        $email =& $this->ajax["email"];
        $user = \AckUsers\Model\Users::getFromMail($email);

        if ($user->getId()->getBruteVal()) {
            $password = $user->resetPassword();
            $destinatary = $user->getEmail()->getVal();

            $result = \AckUsers\Emails\RecuperarSenha::getInstance()
            ->setDestinatary($destinatary)
            ->setUsuario($user->getNome()->getVal())
            ->setNovaSenha($password)
            ->send();

            if ($result) {
                echo json_encode(array(
                            "status" => 1,
                            "mensagem" => "Enviamos um e-mail para você!" ,
                            ));

                return $this->response;
            } else {
                echo json_encode(array(
                            "status" => 0,
                            "mensagem" => "Não foi possível enviar o e-mail." ,
                            ));

                return $this->response;
            }
        }
        echo json_encode(array(
                    "status" => 0,
                    "mensagem" => "Este usuário não existe" ,
                    ));

        return $this->response;
    }
}
