<?php
/**
 * trata dos trabalhos relativos ás metatags do sistema
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
namespace AckCore\Observer;
class MetatagsManager
{
    public function listen(\AckCore\Event\Event $event)
    {
        if ($event->getType() == \AckCore\Event\Event::TYPE_AFTER_MAIN_SAVE) {

            $controller = $event->getController();
            $metaPackage = $controller->getMetaPackage();
            $ajax = $controller->ajax;
            $package  = $event->getPackage();
            $model = $controller->getModel();

            $set =& $ajax[$metaPackage];
            /**
             * salva as metatags caso as mesmas tenham sido passadas
             * (testar a permissão no futuro)
             */
            if (isset($ajax[$metaPackage]) && !empty($ajax[$metaPackage])) {

                $model = $controller->getInstanceOfModel();

                //pega os dados das metatags
                if(is_int($event->getMetaId())) $where = array("id"=>$event->getMetaId());
                else {
                    $where = array("modulo"=>$model->getModuleId(),"relacao_id"=>$ajax[$package]["id"]);
                    $set["modulo"] = $model->getModuleId();
                    $set["relacao_id"] = $ajax[$package]["id"];
                }

                $modelMeta = new \AckCore\Model\Metatags;
                $resultMeta = $modelMeta->updateOrCreate($set,$where);
            }
        }
    }
}
