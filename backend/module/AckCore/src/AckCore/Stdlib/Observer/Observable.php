<?php
/**
 * trait de observer
 *
 * AckDefault - Jean Carlo Machado
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
 * @copyright 2013 Copyright (C) Jean Carlo Machado
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\Stdlib\Observer;
/**
 * trait de observer
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
trait Observable
{
    protected $observers = array();

    /**
     * notifica os observadores
     *
     * @param  \AckCore\Event\Event $message objeto container das informações 
     *
     * @return Object objeto que implementa esta trait
     */
    public function notify(\AckCore\Event\Event $event)
    {
        if($this->getObservers()) {
            foreach ($this->getObservers() as $obj) {
                $obj->listen($event);
            }
        }

        return $this;
    }

    /**
     * adiciona um objeto aos observadores
     *
     * @param  Object $objName objeto que implementa observer
     *
     * @return Object objeto que implementa esta trait
     */
    public function attach($objName)
    {
        $this->observers[$objName] = $objName;

        return $this;
    }
   
    /**
     * remove um objeto pela chave
    
     * @param  Object $objName objeto que implementa observer
     
     * @return Object objeto que implementa esta trait
     */
    public function detach($objName)
    {
        unset($this->observers[$objName]);

        return $this;
    }

    /**
     * retorna a referência dos observers da classe
     *
     * @return array agrupamento de observers attached
     */
    public function &getObservers()
    {
        foreach ($this->observers as $className) {
           $arr[] = new $className;
        }

        return $arr;
    }
    
    /**
     * seta vários observadores de uma só vez
     *
     * @param  array $observers array de ojetos que implementam observer
     * 
     * @return Object objeto que implementa esta trait
     */
    public function setObservers($observers)
    {
        $this->observers = $observers;

        return $this;
    }
}
