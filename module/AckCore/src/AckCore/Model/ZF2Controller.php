<?php
/**
 * classe com funções que tratam de apenas um módulo do ack
 * descricao
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
namespace AckCore\Model;
use AckCore\Object;
use AckCore\Facade;
class ZF2Controller extends Object
{
  const DISABLE_HASH = "#DISABLE_CONTROLLER_BY_SCRIPT";

    public function disableByName($controllerName)
    {
    $this->show("Desabilitando controlador $controllerName");
         if(!\AckMvc\Controller\Utils::isValidName($controllerName))
                $this->out("O nome passado não contém um padrão de nomenclatura correto");

            $this->show("Procurando o controlador pelo nome especificado...");

            $modulesEnabled = Facade::getModulesEnabled();
            $basePath = Facade::getPublicPath();
            $found = false;
            foreach ($modulesEnabled as $module) {
                $modulePath = $basePath. "/../module/$module/src/$module/Controller";
                //entra do diretório
                $files = \AckCore\Utils\Directory::listAllFiles($modulePath);
                if(!empty($files))
                foreach ($files as $file) {
                    if (\AckMvc\Controller\Utils::isValidFileName($file) && \AckMvc\Controller\Utils::getNameFromFile($file) == $controllerName) {
                        //coloca o .disabled no controlador
                      rename($modulePath."/".$file, $modulePath."/".$file.".disabled");

                        $this->show("Controller $controllerName encontrado no módulo: $module ...");
                        $found = true;
                      //abre a configuração do módulo em questão e comenta a  linha de entrada do controlador
                      $configFilePath = $modulePath."/../../../config/module.config.php";
                      $fileObject = \AckCore\Utils\File::getInstance($configFilePath)->open();

                      $partialControllerName = substr($controllerName, 0, -10);
                      $content = ($fileObject->read());
                      $fileObject->close();
                      $search = '"'.$module.'\Controller\\'.$partialControllerName.'" => "'.$module.'\Controller\\'.$controllerName.'"';
                      $replace =  '//"'.self::DISABLE_HASH.''.$module.'\Controller\\'.$partialControllerName.'" => "'.$module.'\Controller\\'.$controllerName.'"';
                      $content = str_replace($search, $replace, $content);
                      $search = str_replace('"', "'", $search);
                      $content = str_replace($search, $replace, $content);
                      //###################################################################################
                      //################################# search and replace do menu principal ###########################################
                      //###################################################################################
                     // $search = 'array("controller"=>"\\'.$module.'\Controller\\'.$controllerName.'"';
                     // $replace =  '//"'.self::DISABLE_HASH.'controller"=>"\\'.$module.'\Controller\\'.$controllerName.'"';
                     // $content = str_replace($search, $replace, $content);

                      //###################################################################################
                      //################################# END search and replace do menu principal ########################################
                      //###################################################################################

                      $fileObject = \AckCore\Utils\File::getInstance($configFilePath)->open("w+");
                      $fileObject->write($content)->save()->close();
                      $this->show("Controlador desabilitado com sucesso!");
                    }
                }
            }

        if(!$found) echo $this->show("Nada encontrado");
    }

    public function enableAll()
    {
      $modulesEnabled = Facade::getModulesEnabled();
      $basePath = Facade::getPublicPath();
      foreach ($modulesEnabled as $module) {
        //###################################################################################
        //################################# reabilita o invokable ###########################################
        //###################################################################################
          $moduleConfigPath = $basePath. "/../module/$module/config";

          if(!file_exists($moduleControllerPath)) continue;

          $search = '//"'.self::DISABLE_HASH;
          \AckCore\Utils\String::searchAndReplace($moduleConfigPath,$search,'"');
        //###################################################################################
        //################################# END reabilita o invokable ########################################
        //###################################################################################
        $moduleControllerPath = $basePath. "/../module/$module/src/$module/Controller";
        //entra do diretório
        $files = \AckCore\Utils\Directory::listAllFiles($moduleControllerPath);
        if(!empty($files))
        foreach ($files as $file) {
          if (substr($file, -9) == ".disabled") {
            $newName = substr($file, 0, -9);
            //coloca o .disabled no controlador
            rename($moduleControllerPath."/".$file, $moduleControllerPath."/".$newName);
          }
        }
      }
    }
    /**
     * mostra uma mensagem no terminal
     * usar ao invés do echo
     * @param  [type] $str [description]
     * @return [type] [description]
     */
    protected function show($str)
    {
        echo $str."\n";
    }
    /**
     * interrompe a execução mostrando uma mensagem de saída
     * @param  string  $outputMessage [description]
     * @param  integer $status        [description]
     * @return [type]  [description]
     */
    protected function out($outputMessage = "",$status=1)
    {
        $message = "Saindo";
        if(!empty($outputMessage))
            $message.= "... mensagem: $outputMessage";
            $this->show($message);

        exit($status);
        }
}
