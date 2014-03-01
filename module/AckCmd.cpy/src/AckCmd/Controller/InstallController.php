<?php
/**
 * rotinas de instalação de módulos entre outros recursos
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
namespace AckCmd\Controller;
use AckMvc\Controller\ConsoleBase;
class InstallController extends ConsoleBase
{
    public function indexAction()
    {
        $this->show("Olá esta é a ferramenta de instalação do ack via linha de comando para um descritivo sobre suas funcionalidades utilize o commando: php index.php install help.\n");
    }

    /**
     * ajuda do controlador
     * @return [type] [description]
     */
    public function helpAction()
    {
        $this->show("Ajuda do módulo de instalação do ack.
                             *  fromModuleConfigAction moduleName \n
                            => instala o ack à partir de um arquivo de configuração dentro do módulo principal
                            ");
    }

    /**
     * instala o ack à partir de um arquivo de configuração dentro do módulo principal
     * ou então com todo o caminho especificado
     * @return [type] [description]
     */
    public function nameAction()
    {
        $moduleName = $this->params()->fromRoute("parameters");
        \AckCore\Utils\String::sanitize($moduleName);
        $modelZf2Module = new \AckCore\Model\ZF2Module;
        $modelZf2Module->install($moduleName);
    }

    /**
     * através de um xml ele instala o módulo e sobrescreve o xml atua do módulo
     * @return [type] [description]
     */
    public function fromXMLConfigAction()
    {
        $xmlFile = ( $this->params()->fromRoute("parameters"));
        \AckCore\Utils\String::sanitize($xmlFile);
        if(!file_exists($xmlFile))
            $this->out("Não foi possível encontrar o arquivo $xmlFile");

        //transforma o xml em um array
        $array = \AckCore\Utils\XML::toArray($xmlFile);
        $mainModule = reset($array["modules"]["module"]);

        $moduleMgr = new \AckCore\Model\ZF2Modules();
        $modelZf2Module = new \AckCore\Model\ZF2Module;

    //se o módulo não existe então cria-o
         if (!$moduleMgr->moduleExists($mainModule)) {
                $modelZf2Module->create($mainModule);
        }
    //copia o xml para o módulo criado
            $newPath = $moduleMgr->getAckConfigFilePath($mainModule);
            if(file_exists($newPath)) unlink($newPath);
            copy($xmlFile,$newPath);
     //instala o módulo propriamente dito
           $modelZf2Module->install($mainModule);
    }
}
