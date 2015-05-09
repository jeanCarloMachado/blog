<?php
/**
 * funções para automatizar a criação de componetes mvc
 *
 * AckDefault - Cub
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\Model;
use AckCore\Object;
use AckCore\Utils\Cmd;
use AckCore\Utils\String;
use AckCore\Utils\String as StringUtilities;
use AckCore\Utils\File;
use AckCore\Facade;
/**
 * funções para automatizar a criação de componetes mvc
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class ZF2Mvc extends Object
{
    protected $zendModuleName = null;
    protected $tableName = null;

    /**
     * cria um componente mvc 1 controller e 2 modelos
     * (table gatway)
     *
     * @param String $basePath caminho inicial
     *
     * @return void null
     */
    public function createEntry($basePath)
    {
        $tableName = $this->getTableName();

        $modelSuggestion = $this->getServiceLocator()->get('genericModel')->composeModelNameSuggestionFromTableName($tableName);
        $modelName = $this->getModelName($modelSuggestion);
        $pluralModelName = $modelName;

        if (Cmd::booleanQuestion("Deseja setar o nome do modelo no plural?", false)) {
            $pluralModelName = Cmd::interact("Digite o nome no plural:", $modelName);
        } else {
            $pluralizer = $this->getServiceLocator()->get('pluralizer');
            $pluralModelName = $pluralizer($modelName);

        }
        //pega o módulo de zend framework o qual o sistema vai instalar
        $zendModuleName = $this->getZendModuleName();
        $moduleName = $modelName;

        //========================= cria os modelos =========================
        //CRIA O MODELO DE LINHA
            $template = new File($basePath."/../Templates/AckModelRow.txt");
            $content = $template->open()->read();
            $template->close();

            $content = str_replace("#MODEL_NAME_PLURAL", $pluralModelName, $content);
            $content = str_replace("#MODEL_NAME", $modelName, $content);
            $content = str_replace("#MODULE_ZEND", $zendModuleName, $content);

            $file = $basePath."/../../../../$zendModuleName/src/$zendModuleName/Model/".$modelName.".php";
            $fileHndlr = new File($file);
            $fileHndlr->open()->write($content)->save()->close();

        //CRIA O MODELO DE TABELA
            $template = new File($basePath."/../Templates/AckModelTable.txt");
            $content = $template->open()->read();
            $template->close();

            $content = str_replace("#MODEL_NAME_PLURAL", $pluralModelName, $content);
            $content = str_replace("#MODEL_NAME", $modelName, $content);
            $content = str_replace("#TABLE_NAME", $tableName, $content);
            // $content = str_replace("#MODULE_NAME", $moduleName, $content);
            // $content = str_replace("#MODULE_ID", $moduleId, $content);
            $content = str_replace("#MODULE_ZEND", $zendModuleName, $content);

            $file = $basePath."/../../../../$zendModuleName/src/$zendModuleName/Model/".$pluralModelName.".php";
            $fileHndlr = new File($file);
            $fileHndlr->open()->write($content)->save()->close();
        //======================= END cria os modelos =======================
        //========================= criação do controlador =========================

        $controllerName = $this->getControllerName();

        if ($controllerName) {

            //CRIA O CONTROLADOR
            $template = new File($basePath."/../Templates/AckController.txt");
            $content = $template->open()->read();
            $template->close();

            $content = str_replace("#CONTROLLER_NAME", $controllerName, $content);
            $content = str_replace("#MODEL_NAME_PLURAL", $pluralModelName, $content);
            $content = str_replace("#MODEL_NAME", $modelName, $content);
            $content = str_replace("#MODULE_ZEND", $zendModuleName, $content);

            $file = $basePath."/../../../../$zendModuleName/src/$zendModuleName/Controller/".$controllerName."Controller.php";
            $fileHndlr = new File($file);
            $fileHndlr->open()->write($content)->save()->close();

            //REGISTRA O CONTROLADOR NO MODULE.CONFIG.PHP
            $file = $basePath."/../../../../$zendModuleName/config/module.config.php";
            $fileHndlr = new File($file);
            $content = $fileHndlr->open("r")->read();
            $fileHndlr->close();

            $replaceWith = '"'.$zendModuleName.'\Controller\\'.$controllerName.'" => "'.$zendModuleName.'\Controller\\'.$controllerName.'Controller",'."\n".'           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS';
            $content = str_replace("//#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS", $replaceWith, $content);

            $fileHndlr->open("w+")->write($content)->save()->close();
            //REGISTRA O CONTROLADOR NO MENU PRINCIPAL DO ACK
            $file = $basePath."/../../../../AckCore/config/module.config.php";
            $fileHndlr = new File($file);
            $content = $fileHndlr->open("r")->read();
            $fileHndlr->close();

            $replaceWith = 'array("controller"=>"\\'.$zendModuleName.'\Controller\\'.$controllerName.'Controller"),'."\n".'             //#NEW_CONTROLLERSMENU_HERE_DO_NOT_REMOVE_THIS';
            $content = str_replace("//#NEW_CONTROLLERSMENU_HERE_DO_NOT_REMOVE_THIS", $replaceWith, $content);
            $fileHndlr->open("w+")->write($content)->save()->close();

        }
        //======================= END criação do controlador =======================
        Cmd::show("Funcionalidade adicionada com sucesso!");
    }

     /**
     * mapeia um controlador e dois modelos do ack no módulo desejado
     * (mover toda esta sessão para um modelo)
     * @return [type] [description]
     */
    public function mapAction()
    {

    }

    /**
     * retorna o nome do controlador passado
     * pelo usuário
     *
     * @return string controllerName
     */
    protected function getControllerName()
    {
        echo "Digite o nome do controlador do ack (sem o sufixo, com a primeira letra em caixa alta), procure utilizar os nomes no plural:";
        $controllerName = fgets(STDIN);

        StringUtilities::sanitize($controllerName);

        $controllerName = ucfirst($controllerName);

        return $controllerName;
    }

    protected function getModelName($tableName = null)
    {
        $modelName =  Cmd::interact("Digite o nome do Modelo do ack, no singular com a primeira letra em caixa alta ( o sistema criará o modelo de tabela no plural automaticamente ) Valor default: < $tableName >",$tableName);

        return $modelName;
    }

    protected function getModuleName($default = null)
    {
        echo "Digite o nome do módulo para o ack no banco (default = $default), dê preferenência para nomes entendíveis pelo usuário final:";
        $moduleName = fgets(STDIN);

        String::sanitize($moduleName);

        if(empty($moduleName))
            $moduleName = $default;

        return $moduleName;
    }

    /**
     * encontra o nome da tabela
     * @return [type] [description]
     */
    protected function getTableName()
    {
        if(!empty($this->tableName)) return $this->tableName;

        $tables = \AckDb\ZF1\Utils::getTablesList();
        setTable:
        print_r($tables);
        echo "Digite o nome da tabela (ou o seu indice):";
        $tableName = fgets(STDIN);
        String::sanitize($tableName);

        if (array_key_exists($tableName, $tables)) {
                $tableName = $tables[$tableName];
        } elseif (in_array($tableName, $tables)) {
                 $tableName = $tableName;
        } else {
                system("clear");
                echo "tabela inexistente\n";
                goto setTable;
        }

        return $tableName;
    }

    /**
     * retona o nome do módulo do zend
     *
     * @return void null
     */
    protected function getZendModuleName()
    {
        if (!empty($this->zendModuleName)) {
            return $this->zendModuleName;
        }

        $config = Facade::getServiceManager()->get('ApplicationConfig');

        $default = $config['modules'][0];
        echo "Digite o nome do módulo do zend framework 2: (default = $default):";
        $moduleName = fgets(STDIN);

        String::sanitize($moduleName);

        if(empty($moduleName))
            $moduleName = $default;

        return $moduleName;
    }

    public function setZendModuleName($zendModuleName)
    {
        $this->zendModuleName = $zendModuleName;

        return $this;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }
}
