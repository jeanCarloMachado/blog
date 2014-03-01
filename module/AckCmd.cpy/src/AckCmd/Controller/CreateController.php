<?php
/**
 * controllador para a criação de diversos recursos
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
/**
 * controllador para a criação de diversos recursos
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class CreateController extends ConsoleBase
{
    public function indexAction()
    {
        $this->show("Olá esta é a ferramenta de criação do ack via linha de comando para um descritivo sobre suas funcionalidades utilize o commando: php index.php create help.\n");
    }
    /**
     * cria um módulo principal de um site (aquele que contém o layout do front)
     * @return [type] [description]
     */
     public function mainModuleAction()
     {
            $moduleName = $this->params()->fromRoute("parameters");
            \AckCore\Utils\String::sanitize($moduleName);
            $modelZf2Module = new \AckCore\Model\ZF2Module;
            $modelZf2Module->create($moduleName);
     }
}
