<?php
/**
 * e-mail enviado para o cliente após a solicitação de um acesso ao sistema
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
namespace AckUsers\Emails;
use AckCore\Mail\EmailEncapsulatedAbstract;
class SolicitarNovoUsuario extends EmailEncapsulatedAbstract
{
    protected $subject = "Solicitação de acesso ao site.";

    public function defaultLayout()
    {
        ?>
        <div style="font-family:Verdana, Geneva, sans-serif; font-size:21px; color:#656666; padding:35px 0 0 50px;">Olá!.</div>
        <div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#656666; padding:35px 50px 30px 50px; line-height:20px;">
       Percebemos que você solicitou o acesso à ferramenta de orçamentos online da Elefran. Nossa equipe já foi notificada e, em breve, entrará em contato com você para liberar o seu acesso.
       <br />
       <br />
       Atenciosamente.<br />
        Equipe da Elefran.
        <?php
    }
}
