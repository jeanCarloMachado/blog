<?php
namespace AckUsers\Observer;
use AckCore\Interfaces\Core\Observer;
class DevilPermissionTester implements Observer
{
    /**
     *  escuta o notify de um objeto do tipo observer e trata-o a sua maneira
     */
    public function listen(\AckCore\Event $event)
    {
        if ($event->getType() == \AckCore\Event::TYPE_RESTRICTED_REQUEST) {

            $controller = $event->getController();

            if (\AckCore\Facade::getCurrentUser()->getId()->getBruteVal() != 32) {
                if ($controller == \AckCore\Facade::getUrlController()) {
                    header("Location: /error/404");
                    die;
                } else {
                    throw new \Exception("Área bloqueada para este usuário");
                }
            }

        }
    }
}
