<?php
namespace AckCmd\Controller;
use Zend\Mvc\Controller\AbstractActionController,
Zend\Console\Request as ConsoleRequest;
use \AckCore\Utils\Cmd;
class HelpController extends AbstractActionController
{
    public function indexAction()
    {
         $request = $this->getRequest();
        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        Cmd::show("\nPágina principal de ajuda da linha de comando do ack\n");
        Cmd::show("Sintaxe básica: php index.php [<contexto>] [<acao>] [<parâmetros>]\n");
        Cmd::show("OBS: Esta ajuda não está nem razoavelmente implementada, então se for possível, recomendo vizualizar o código dos controladores do módulo CMD, ou então entrar em contato comigo j34nc4rl0@gmail.com \n");
    }
}
