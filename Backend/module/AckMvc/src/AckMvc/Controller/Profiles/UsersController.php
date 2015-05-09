<?php
namespace AckMvc\Controller\Profiles;
use AckMvc\Controller\Base;
class UsersController extends Base
{
    /**
     * url de redirecionamento após a autenticação
     * @var string
     */
    protected $defaultRedirectPage = "/usuarios/perfil";
    protected $newPasswordFieldName = "new_senha";
    protected $newPasswordFieldName2 = "conf_new_senha";
    protected $passwordFieldName = "senha";

    //###################################################################################
    //################################# páginas de ajax ###########################################
    //###################################################################################
    /**
     * salva o perfil do usuário
     * @return [type] [description]
     */
    protected function salvarAjax()
    {
        $set  = \AckCore\Utils\Ajax::extractData($this->ajax);
        $user = \AckCore\Facade::getCurrentUser();

        if (!empty($set[$this->passwordFieldName])) {
            if ($set[$this->newPasswordFieldName] != $set[$this->newPasswordFieldName2]) {
                \AckCore\Utils\Ajax::notifyEnd(0,"As novas senhas são incompatíveis");
            }
            if (\AckCore\Utils\Encryption::encrypt($set[$this->passwordFieldName]) != $user->getSenha()->getBruteVal()) {
                \AckCore\Utils\Ajax::notifyEnd(0,"A senha antiga não está correta");
            }
            $set[$this->passwordFieldName] = $set[$this->newPasswordFieldName];
        }

        $set["nome"] = $set["razao_social"];
        $set["nome_tratamento"] = $set["nome_fantasia"];
        $set["nome_tratamento"] = $set["nome_fantasia"];

        $model  = new \AckUsers\Model\Users();

        $result = $model->update($set,array("id"=>$user->getId()->getBruteVal()));
        \AckCore\Utils\Ajax::notifyEnd(1);
    }

    /**
     * função para a recuperação de senha
     * @return [type] [description]
     */
    public function recsenhaAjax()
    {
        $email =& $this->ajax["email"];
        $user = \AckUsers\Model\Users::getFromMail($email);

        if (!empty($user)) {
            $vars["novaSenha"] = $user->resetPassword();
            //tmpCode =======================
            //\AckCore\Mail\Sender::setDebug(1);
            //endTmpCode====================
            $destinatary = $user->getEmail()->getVal();
            $vars["usuario"] = $user;

            $result = \AckCore\Mail\Sender::send(
                                $vars,
                                "Recuperação de senha",
                                $_SERVER["DOCUMENT_ROOT"]."/../module/Ack/view/emails/rec_senha.phtml",
                                $destinatary
                            );
            if ($result) {
                echo json_encode(array("status"=>1,"mensagem"=>("Enviamos um e-mail para você!")));
                exit(1);
            }
        }

        echo json_encode(array("status"=>0,"mensagem"=>("Este usuário não existe")));

        return $this->response;
    }

    /**
     * autentica um usuário
     * @return [type] [description]
     */
    protected function loginAjax()
    {
        $auth = new \AckUsers\Auth\User;
        $this->ajax = \AckCore\Utils\Ajax::extractData($this->ajax);
        if ($auth->authenticate($this->ajax["email"],$this->ajax["senha"])) {
            $user = $auth->getIdentity();

            if (!$user->getacessofront()->getBruteVal()) {
                $auth->logoff();
                echo json_encode(array("status"=>0, "mensagem" => "Não foi possível efetuar login"));

                return $this->response;
            }

            echo json_encode(array("status"=>1,"url"=>$this->defaultRedirectPage, "mensagem" => "Login efetuado"));
        } else {
            echo json_encode(array("status"=>0, "mensagem" => "Não foi possível efetuar login"));
        }

        return $this->response;
    }

    public function solicitaracessoAjax()
    {
        $model = new \AckUsers\Model\Users;

        $set["nome"] = $this->ajax["nome"];
        $set["email"] = $this->ajax["email"];
        $set["senha"] = 123456;
        $set["acessoack"] =0 ;
        $set["acessofront"] = 0;

        $result = $model->create($set);

        \AckCore\Utils\Ajax::notifyEnd(1);
    }

    public function troca_senhaAjax()
    {
        $data = \AckCore\Utils\Ajax::extractData($this->ajax);
        $password = $this->ajax["new_senha"];
        $password2 = $this->ajax["conf_new_senha"];
        $oldPassword = $this->ajax["old_senha"];

        if ($password == $password2) {

            $user = \AckCore\Facade::getCurrentUser();

            if (\AckCore\Utils\Encryption::encrypt($oldPassword) != $user->getSenha()->getBruteVal()) {
                echo json_encode(array("status"=>0,"mensagem"=>"Senha antiga incompatível"));
                exit(1);
            }

            $userModel = new \AckUsers\Model\Users;
            $result = $userModel->update(array("senha"=>$password),array("id"=>$user->getId()->getBruteVal()));
            //tmpcode =================
            //\AckCore\Mail\Sender::setDebug(1);
            //endtmpcode ==============

            \AckCore\Mail\Sender::send(
                                array("set"=>array("user"=>$user,"newPassword"=>$password)),
                                ("Mudança de senha Imgstock"),
                     $_SERVER["DOCUMENT_ROOT"]."/../module/Ack/view/emails/troca_senha.phtml",
                                    $user->getEmail()->getVal(),
                                    null
                              );

            echo json_encode(array("status"=>1,"mensagem"=>"Senha alterada com sucesso!"));
            exit(0);
        }

        echo json_encode(array("status"=>0,"mensagem"=>"Senhas incompatíveis"));
        exit(0);
    }

    //###################################################################################
    //################################# END páginas de ajax ########################################
    //###################################################################################
    //###################################################################################
    //################################# actions ###########################################
    //###################################################################################
    /**
     * action default para montar a página de perfil do usuário
     * @return [type] [description]
     */
    public function perfilAction()
    {
        $vars = array();
        $vars["row"] = \AckCore\Facade::getCurrentUser();
        $this->viewModel->setVariables($vars);

        return $this->viewModel;
    }
    /**
     * faz logou no sistema
     * @return [type] [description]
     */
    public function logoutAction()
    {
        $auth = new \AckUsers\Auth\User;
        $auth->logoff();
        header("Location: /");
        exit(0);
    }
    //###################################################################################
    //################################# END actions ########################################
    //###################################################################################
    //###################################################################################
    //################################# compatibilidade de nomenclatura ###########################################
    //###################################################################################
    public function logoffAction()
    {
        $this->logoutAction();

        return $this->response;
    }
    public function editprofileAjax()
    {
        $this->salvarAjax();

        return $this->response;
    }
    //###################################################################################
    //################################# END compatibilidade de nomenclatura ########################################
    //###################################################################################

}
