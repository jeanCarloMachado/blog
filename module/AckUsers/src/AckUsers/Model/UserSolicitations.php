<?php
namespace AckUsers\Model;
use AckDb\ZF1\TableAbstract as Table;
class UserSolicitations extends Table
{
    protected $_name = "ack_solicitacao_acesso";
    protected $_row = "\AckUsers\Model\UserSolicitation";

    const moduleName = "UserSolicitation";
    const moduleId = 43;

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "acesso_garantido" => "Acesso concedido",
        "email" => "E-mail"
    );

    public function create(array $set, array $params = array())
    {
        //testes iniciais
        //inicializacao de variáveis
        //negócio da função
        $this->toObject();
        $userSolicitation = parent::create($set,$params);
        //envia os e-mails para os usuários respectivos
        if ($userSolicitation->getId()->getBruteVal()) {
            $emailNewUser  = new \AckUsers\Emails\SolicitarNovoUsuario;
            $emailNewUser->setDestinatary($userSolicitation->getEmail()->getVal())->send();
            $emailAck  = new \AckUsers\Emails\SolicitacaoNovoUsuario;
            $emailAck->setDestinatary(\AckCore\Model\System::getDefaultEmail())->setUser($userSolicitation)->send();
        }

        return $userSolicitation->getId()->getBruteVal();
    }

    public function update(array $set,$where)
    {
        $result = parent::update($set,$where);
        //caso o acesso tenha sido garantido para um usuário (cria-se o mesmo);
        if (isset($set["acesso_garantido"]) && $set["acesso_garantido"] && !empty($result) && !is_array($result)) {
            //envia o e-mail de liberação de usuário para o cliente e cria o usuário eferiavamente.
            $solicitation = $this->get(array("id"=>$result));
            $solicitation = reset($solicitation);
            unset($solicitation["id"]);
            $modelUsers = new \AckUsers\Model\Users;
            $solicitation["acessofront"]=true;
            try {
                $result = $modelUsers->toObject()->createFillingRequired($solicitation,array());
            } catch (\Exception $e) {
                \AckCore\Utils\Ajax::notifyEnd(0,$e->getMessage());
            }
        }

        if(!$result) \AckCore\Utils\Ajax::notifyEnd(0,"Nenhuma alteração efetuada.");

        return $result;
    }
}
