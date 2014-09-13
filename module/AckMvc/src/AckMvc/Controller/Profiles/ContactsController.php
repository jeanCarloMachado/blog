<?php
/**
 * controlador padrão que automatiza alguns processos de uma sessão de contatos
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
namespace AckMvc\Controller\Profiles;
use AckMvc\Controller\Base;
class ContactsController extends Base
{
    /**
     * envia um contato
     * @return [type] [description]
     */
    public function contatosAjax()
    {
        $set = \AckCore\Utils\Ajax::extractData($this->ajax);
        $set["remetente"] = $set["nome"];
        $set["fone"] = $set["telefone"];

        $set["data"] = \AckCore\Utils\Date::now();

        $modelContacts = new \AckContact\Model\Contacts;
        $result = $modelContacts->create($set);
        //###################################################################################
        //################################# envio de email ###########################################
        //###################################################################################
        $resultSystem = \AckCore\Model\Systems::getCurrent();
        $email = new \AckContact\Emails\Contato;
        $emailAck = new \AckContact\Emails\ContatoAck;
        $email->setRemetente($set["nome"])->setEmail($set["email"])->setMensagem($set["mensagem"])->setDestinatary($set["email"])->send();
        $emailAck->setRemetente($set["nome"])->setEmail($set["email"])->setMensagem($set["mensagem"])->setDestinatary($resultSystem->getEmail()->getVal())->send();
        //###################################################################################
        //################################# END envio de email ########################################
        //###################################################################################
        \AckCore\Utils\Ajax::notifyEnd($result);
    }
    /**
     * função de compatibilidade
     * @return [type] [description]
     */
    protected function sendcontactAjax()
    {
        return $this->contatosAjax();
    }
    /**
     * envia um currrículo
     * @return [type] [description]
     */
    protected function sendcurriculumAjax()
    {
        $set = \AckCore\Utils\Ajax::extractData($this->ajax);
        $model = new \AckContact\Model\Curriculos;
        $result = $model->create($set);
        //###################################################################################
        //################################# envio de email ###########################################
        //###################################################################################
        $resultSystem = \AckCore\Model\Systems::getCurrent();
        $email = new \AckContact\Emails\Curriculo;
        $emailAck = new \AckContact\Emails\CurriculoAck;
        $email->setRemetente($set["nome"])->setEmail($set["email"])->setId($result)->setDestinatary($set["email"])->send();
        $emailAck->setRemetente($set["nome"])->setEmail($set["email"])->setId($result)->setDestinatary($resultSystem->getEmail()->getVal())->send();
        //###################################################################################
        //################################# END envio de email ########################################
        //###################################################################################
        \AckCore\Utils\Ajax::notifyEnd($result);
    }
}
