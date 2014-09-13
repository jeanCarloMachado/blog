<?php
/**
 * assistente para o mapeamento de novas funcionalidades mvc.
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
namespace AckCmd\Model;
use AckCore\Object;
use AckCore\Utils\Cmd;
class MvcMapperAssistant extends Object
{
    protected $mainModel;
    protected $terminal;
    protected $currentNamespace;
    protected $basePath;
    protected $zendModuleName;

    public function __construct($mainModel)
    {
        $this->mainModel = $mainModel;
    }

    /**
     * inciializa o processo de mapeamento
     * @return [type] [description]
     */
    public function setup()
    {
        Cmd::show("Descobrindo as entidades deste namespace");
        if ($this->getCurrentNamespace()) {
            $tables = \AckDb\ZF1\Utils::getTableNamesFromNamespace($this->getCurrentNamespace());
        } else {
            $tables = \AckDb\ZF1\Utils::getInstance()->getTablesList();
        }
        foreach ($tables as $table) {
            Cmd::show("Iniciando processamento para a tabela < $table > ");
            $this->getMainModel()->setTableName($table)->setZendModuleName($this->getZendModuleName())->createEntry($this->getBasePath(),$table);
        }

        return true;
    }

    //###################################################################################
    //################################# getters and setters ###########################################
    //###################################################################################
    public function getMainModel()
    {
        return $this->mainModel;
    }

    public function setMainModel($mainModel)
    {
        $this->mainModel = $mainModel;

        return $this;
    }

    public function getTerminal()
    {
        return $this->terminal;
    }

    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;

        return $this;
    }

    public function getCurrentNamespace()
    {
        return $this->currentNamespace;
    }

    public function setCurrentNamespace($currentNamespace)
    {
        $this->currentNamespace = $currentNamespace;

        return $this;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function getZendModuleName()
    {
        return $this->zendModuleName;
    }

    public function setZendModuleName($zendModuleName)
    {
        $this->zendModuleName = $zendModuleName;

        return $this;
    }
    //###################################################################################
    //################################# END getters and setters ########################################
    //###################################################################################
}
