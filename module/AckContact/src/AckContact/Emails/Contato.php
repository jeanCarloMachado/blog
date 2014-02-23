<?php
/**
 * email default de contato
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
namespace AckContact\Emails;
use AckCore\Mail\EmailEncapsulatedAbstract;
class Contato extends EmailEncapsulatedAbstract
{
    protected $subject = "Contato enviado";
    public function defaultLayout()
    {
        ?>
            </br>
            <div style="font-family:Verdana, Geneva, sans-serif; font-size:21px; color:#656666; padding:35px 0 0 50px;"><b>Olá, <?php echo $this->getRemetente() ?></b></div>
            <div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#656666; padding:35px 50px 30px 50px; line-height:20px;">

                Obrigado por nos enviar sua mensagem através do site da Elefran.
            Assim que possível, entraremos em contato com você.
            Até breve!

          <br /><br />
          Atenciosamente.<br />
        Equipe da Elefran.
        <?php
    }

}
