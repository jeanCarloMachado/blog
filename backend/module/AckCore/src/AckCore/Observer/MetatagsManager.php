<?php

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

            echo "<pre>"; var_dump($metaPackage); die;
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
