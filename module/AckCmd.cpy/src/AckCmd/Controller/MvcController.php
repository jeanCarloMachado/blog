<?php
/**
 * funcionalidades de mapeamentos de códigos (criação)
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
namespace AckCmd\Controller;
use AckMvc\Controller\ConsoleBase;
use AckCore\Model\ZF2Mvc;
use AckCore\Utils\Cmd;
use AckCore\Utils\String;
/**
 * funcionalidades de mapeamentos de códigos (criação)
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class MvcController extends ConsoleBase
{
    /**
     * mapeia uma tabela do banco de
     * dados podendo derivar em no máximo
     * dois modelos e um controlador
     *
     * @return void null
     */
    public function mapAction()
    {
        $model = $this->getServiceLocator()->get('ZF2Mvc');
        $model->createEntry(dirname(__FILE__));
    }

    /**
     * mapeia um namespace com models e possivelmente controladores
     *
     * @return void null
     */
    public function mapNamespaceAction()
    {
        $basePath = dirname(__FILE__);
        $assistant = $this->getServiceLocator()->get('MvcMapperAssistant');
        $namespace = $this->params()->fromRoute("parameters");
        if(!$namespace) $namespace = Cmd::interact("Digite o namespace para utilizar");
        String::sanitize($namespace);

        $zendModuleName = Cmd::interact("Digite o nome do módulo do zend framework 2 que você deseja instalar este namespace");

        String::sanitize($zendModuleName);

        $assistant->setTerminal(true)->setZendModuleName($zendModuleName)->setBasePath(dirname(__FILE__))->setCurrentNamespace($namespace)->setup();
    }

    /**
     * mapeia todo o banco de dados automaticamete
     *
     * @return void null
     */
    public function mapAllDatabaseAction()
    {
        $basePath = dirname(__FILE__);
        $assistant = $this->getServiceLocator()->get('MvcMapperAssistant');
        $namespace = $this->params()->fromRoute("parameters");
        if(!$namespace) $namespace = Cmd::interact("Digite o namespace para utilizar");

        String::sanitize($namespace);

        $zendModuleName = Cmd::interact("Digite o nome do módulo do zend framework 2 que você deseja instalar este namespace");

        String::sanitize($zendModuleName);

        $assistant->setTerminal(true)->setZendModuleName($zendModuleName)->setBasePath(dirname(__FILE__))->setup();
    }

    /**
     * registra um controlador
     *
     * @return void null
     */
    public function registerControllerAction()
    {
        $parameters = $this->params()->fromRoute("parameters");
        $parameters = explode(' ', $parameters);

        \AckCore\Debug\Debug::dg($parameters);
    }
}
