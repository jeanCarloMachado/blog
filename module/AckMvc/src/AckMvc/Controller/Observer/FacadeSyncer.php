<?php
/*
* Place includes, constant defines and  settings here.
* Make sure they have appropriate docblocks to avoid phpDocumentor
* construing they are documented by the page-level docblock.
*/

/**
 * sincronizador do facade do sistema
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
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @link       http://www.icub.com.br
 */
namespace AckMvc\Controller\Observer;
class FacadeSyncer
{
    public function listen(\AckCore\Event\Event $event)
    {
        if ($event->getType() == \AckCore\Event\Event::TYPE_ACTION_DISPATCH) {
            $config = $event->getConfig();
            \AckCore\Facade::getInstance()->setCurrentRow($config["row"]);
        }
    }
}
