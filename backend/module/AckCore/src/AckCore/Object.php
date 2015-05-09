<?php
/**
 * tipo básico de um sistmea, quando um objeto não extende nada
 * pode-se extender desta classe pois ela oferece diversos recursos interessantes
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
namespace AckCore;
use AckCore\Stdlib\Observer\Observable;
use AckCore\Stdlib\ServiceLocator\ServiceLocatorAware;
/**
 * tipo básico de um sistmea, quando um objeto não extende nada
 * pode-se extender desta classe pois ela oferece diversos recursos interessantes
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Object 
{
    use Observable;
    use ServiceLocatorAware;
    
    public function __construct()
    {
        foreach($this->observers as $observer)
            $this->attach($observer);
    }
        /**
     * retorna uma instância
     * isso não é singleton simplesmente serve para
     * facilitar o acesos sem a necessidade de
     * dar um new
     * @return [type] [description]
     */
    public static function getInstance()
    {
        $class = get_called_class();

        return new $class;
    }
    
}
