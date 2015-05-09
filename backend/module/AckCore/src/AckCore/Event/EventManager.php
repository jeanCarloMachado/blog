<?php
/**
 * eventos do sistema
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
namespace AckCore\Event;
class EventManager
{
    //###################################################################################
    //################################# tipos de eventos disponíveis ###########################################
    //###################################################################################
    //utilizado quando uma àrea é privada e necessita
    //de autenticação para ser utilizada
    const TYPE_RESTRICTED_REQUEST = 1;
    //quando vai renderizar uma view
    const TYPE_ACTION_DISPATCH = 2;
    const TYPE_AFTER_MAIN_SAVE = 3;
    const TYPE_ACCESS_REQUEST = 4;
    const TYPE_ROW_CREATED = 5;
    const TYPE_NOT_PERMITED_ACCESS = 6;
    const TYPE_NEW_USER = 7;
    //###################################################################################
    //################################# END tipos de eventos disponíveis ########################################
    //###################################################################################
}
