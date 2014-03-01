<?php
namespace AckCmd\Controller;
use AckMvc\Controller\ConsoleBase;
class ModulesController extends ConsoleBase
{
    public function indexAction()
    {
        $moduleMgr = new \AckCore\Model\ZF2Modules();
        \AckCore\Utils::dg($moduleMgr->getAllModulesAvailable());
    }
}
