<?php
/**
 * boot que comprimenta o usuário de
 * acordo com o horário
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
namespace AckContent\View\Helper;
use Zend\View\Helper\AbstractHelper;
use AckCore\Utils\Date as DateUtilities;

/**
 * boot que comprimenta o usuário de
 * acordo com o horário
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class PolishedBoot extends AbstractHelper
{

    public function sayHello($user = null)
    {
        $message = '';

        $time = DateUtilities::getTime();
        $hour = explode(':', $time);
        $hour = reset($hour);

        if (preg_match('/ 0? | 1[01]/', $hour)) {
            $message = 'Bom dia';
        } elseif (preg_match('/1[2-7]/', $hour)) {
            $message = 'Boa tarde';
        } else {
            $message = 'Boa noite';
        }

        if ($user) {
            $userName = explode(' ',$user->getNome()->getVal());
            $message.= ' '.$userName[0];
        }

        return $message;

    }

    /**
     * getter de User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * setter de User
     *
     * @param int $User
     *
     * @return $this retorna o próprio objeto
     */
    public function setUser($User)
    {
        $this->User = $User;

        return $this;
    }
}
