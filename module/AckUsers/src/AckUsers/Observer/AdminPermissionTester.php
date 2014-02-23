<?php
namespace AckUsers\Observer;
use AckCore\Interfaces\Core\Observer;
class AdminPermissionTester implements Observer
{
    /**
     *  escuta o notify de um objeto do tipo observer e trata-o a sua maneira
     */
    public function listen(\AckCore\Event $event)
    {

        if ($event->getType() == \AckCore\Event::TYPE_RESTRICTED_REQUEST) {

            if (!\AckCore\Facade::getCurrentUser()->hasGroupPermission(\AckUsers\Model\Group::GROUP_ADMIN)) {

                    throw new \Exception("Área do controlador: $controller bloqueada para este usuário");
            }

        }
    }
}
