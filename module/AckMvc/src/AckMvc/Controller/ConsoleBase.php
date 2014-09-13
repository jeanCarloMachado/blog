<?php
/**
 * esta classe implementa facilities para controllers de terminal
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
namespace AckMvc\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AckCore\Utils\Cmd;
abstract class ConsoleBase extends AbstractActionController implements ServiceLocatorAwareInterface
{
    // /**
    //  * faz uma pergunta que admite somente verdadeiro ou falso
    //  * @param  [type]  $question   [description]
    //  * @param  boolean $defaultVal [description]
    //  * @return [type]  [description]
    //  */
    // protected function booleanQuestion($question,$defaultVal = true)
    // {
    //    return \AckCore\Utils\Cmd::booleanQuestion($question,$defaultVal);
    // }
    // /**
    //  * mostra uma mensagem no terminal
    //  * usar ao invés do echo
    //  * @param  [type] $str [description]
    //  * @return [type] [description]
    //  */
    // protected function show($str)
    // {
    //     return \AckCore\Utils\Cmd::show($str);
    // }
    // /**
    //  * sai  do processo apresentando uma mensagem para o usuario
    //  * @param  string  $outputMessage [description]
    //  * @param  integer $status        [description]
    //  * @return [type]  [description]
    //  */
    // protected function out($outputMessage = "",$status=1)
    // {
    //     return \AckCore\Utils\Cmd::out($outputMessage = "",$status=1);
    // }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
