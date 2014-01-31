<?php
/**
 * functionalidade DEPRECATED
 *
 * descrição detalhada
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

namespace AckUsers\Observer;
use AckCore\Interfaces\Core\Observer;
class NewUser implements Observer
{
    /**
     *	escuta o notify de um objeto do tipo observer e trata-o a sua maneira
     */
    public function listen(\AckCore\Event $event)
    {
        $result = $event->getResult();
        if(is_array($result))
        $result = reset($result);

        if ($event->getType() == \AckCore\Event::TYPE_NEW_USER && !empty($result)) {

            $user = \AckUsers\Model\Users::getFromId($result);

            //manda o e-mail para o usuário criado
            if ($user) {
                $email = new \AckUsers\Emails\NovoUsuario;
                $email->setDestinatary($user->getEmail()->getBruteVal())->setPassword($event->getPassword())->send();
            }
        }
    }
}
