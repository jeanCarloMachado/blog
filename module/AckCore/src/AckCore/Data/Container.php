<?php
/**
 * gerenciador de dados (utilizado no controlador)
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
namespace AckCore\Data;
class Container
{
    public $data;
    protected static $instance;

    public static function getInstance()
    {
        if(empty(self::$instance))
            self::$instance = new Container;

        return self::$instance;
    }

    private function __construct() {}

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) return $this->data[$name];
        return null;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function __call($method, array $args)
    {
        if(method_exists($this, $method)) return false;
        /**
         * [$methodName description]
         * @var [type]
         */
        $attrName = strtolower(substr($method, 3));
        $action = substr($method,0,3);

        if ($action == "get") {
            return $this->getVar($attrName);
        } elseif ($action == "set") {

            $val = reset($args);

            return $this->setVar($attrName,$val);
        }

        throw new \Exception("método desconhecido (".$attrName.") - verfique System_DB_Table_Row");
    }

    public function setVar($column,$value)
    {
        $this->data[$column] = $value;

        return $this;
    }

    public function getVar($key)
    {
        if (isset($this->data[$key])) return $this->data[$key];

        else return null;
    }
}
