<?php
/**
 * configurador default de controllers sem configuração
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
namespace AckMvc\Controller\Helper;
use AckCore\Object;
/**
 * configurador default de controllers sem configuração
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class AutomaticallyGeneratedControllerConfig extends Object
{
    protected $modelInstance;

    protected $blackListedColumns = array('id','ordem', 'status', 'visivel');

    public function getConfig()
    {
        $config = array();

        $config['global']['blacklist'] = $this->getBlackListedColumns();

        $prototype = $this->getModelInstance()->getRowPrototype();

        $counter = 0;
        foreach ($prototype->vars as $varName => $object) {

            if (in_array($varName, $this->getBlackListedColumns()) || $counter > 8) {
                continue;
            }

            $config['lista']['whitelist'][] = $varName;
            $counter++;
        }

        return $config;
    }

    /**
     * getter de BlackListedColumns
     *
     * @return BlackListedColumns
     */
    public function getBlackListedColumns()
    {
        return $this->blackListedColumns;
    }

    /**
     * setter de BlackListedColumns
     *
     * @param int $blackListedColumns
     *
     * @return $this retorna o próprio objeto
     */
    public function setBlackListedColumns($blackListedColumns)
    {
        $this->blackListedColumns = $blackListedColumns;

        return $this;
    }

    /**
     * getter de ModelInstance
     *
     * @return ModelInstance
     */
    public function getModelInstance()
    {
        return $this->ModelInstance;
    }

    /**
     * setter de ModelInstance
     *
     * @param int $ModelInstance
     *
     * @return $this retorna o próprio objeto
     */
    public function setModelInstance($ModelInstance)
    {
        $this->ModelInstance = $ModelInstance;

        return $this;
    }
}
