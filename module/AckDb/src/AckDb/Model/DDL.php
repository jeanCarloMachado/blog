<?php

/**
 * DDL = data definition language (esta classe abstrai funcionalidades para alterar o banco de dados)
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
namespace AckDb\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DDL implements ServiceLocatorAwareInterface
{
    protected $relatedTable;

    protected $serviceLocator;

    /**
     * adiciona coluna a uma tabela
     *
     * @param (string) $columnName nome da coluna
     * @param (string) $table      nome da tabela
     * @param (string) $type       tipo da coluna
     *
     * @return void
     */
    public function addColumn($columnName,$table,$type="VARCHAR(50)")
    {
        if ($table->hasColumn($columnName)) {
            return true;
        }

        $tableName = $table->getTableName();
        $result = $table->run("ALTER TABLE $tableName ADD COLUMN $columnName $type");

        return $result;
    }

    /**
     * pega a tabela relacionada
     *
     * @return void
     */

    public function getRelatedTable()
    {
        return $this->relatedTable;
    }

    /**
     * seta a tabela relacionada
     *
     * @param (string) $relatedTable tabela relacionada
     *
     * @return void
     */

    public function setRelatedTable($relatedTable)
    {
        $this->relatedTable = $relatedTable;

        return $this;
    }
    /**
     * deleta uma tabela
     *
     * @param (string) $tableName nome da tabela a ser removida
     * @param (string) $model     nome da tabela a ser removida
     *
     * @return void
     */
    public function dropTable($tableName, $model=null)
    {
        $result = $model->run("DROP TABLE IF EXISTS $tableName");

        return $result;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
