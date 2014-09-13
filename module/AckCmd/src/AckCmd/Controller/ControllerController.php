<?php
/**
 * descricao
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
class ControllerController extends ConsoleBase
{
    /**
    * cria um módulo principal de um site (aquele que contém o layout do front)
    * @return [type] [description]
    */
    public function disableByNameAction()
    {
        $controllerName = $this->params()->fromRoute("parameters");
        if(empty($controllerName)) Cmd::out("Deve-se passar o nome do controlador como primeiro parâmetro no seguinte padrão: NomeDoControladorController");

        $controllerName[0] = $controllerName;
        \AckCore\Utils\String::sanitize($controllerName);

        $modelZF2Controller = new \AckCore\Model\ZF2Controller;
        $vars["ZF2Controller"] = $modelZF2Controller->disableByName($controllerName);

        Cmd::out("bloqueio do controlador $controllerName concluído.");
    }

    public function enableAllAction()
    {
        $this->show("Inciando processo de habilitação de todos os controladores.");
        $modelZF2Controller = new \AckCore\Model\ZF2Controller;
        $vars["ZF2Controller"] = $modelZF2Controller->enableAll();
        Cmd::out("Habilitação de todos os controladores concluída.");
    }
}
