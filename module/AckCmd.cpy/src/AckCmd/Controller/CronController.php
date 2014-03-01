<?php
namespace AckCmd\Controller;
use AckMvc\Controller\ConsoleBase;
use AckCore\Utils\Cmd;
use AckKnow\Script\EmailNotifier;
class CronController extends ConsoleBase
{
    public function remindersAction()
    {
        $EmailNotifier = new EmailNotifier;
        $EmailNotifier->run();
        Cmd::show("Processo finalizado com sucesso!");
    }
}
