<?php
/**
 * utilitários do banco de dadsos
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
namespace AckDb\ZF1;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Utils implements ServiceLocatorAwareInterface
{
    protected $relatedTable;

    public static function getIdsFromObjectsArray(array &$arr)
    {
        $result = array();
        foreach ($arr as $key => $val) {

            $result[$val->getId()->getBruteVal()] = $val->getId()->getBruteVal();
        }

        return $result;
    }

    public static function stringfyWhere(array $where)
    {
        $str = " ";

        foreach ($where as $key => $value) {

            //testa se a chave tem espaços
            //caso tenha então ela contém os
            //caracteres comparativos e o = é desnecessário
            if(strpos($key, " "))
                $str.= "$key $value";
            else
                $str.=" $key = $value";

            $str.= "  AND ";
        }

        $str = substr($str, 0, -5);

        dg($str);

        return $str;
    }
    /**
     * retona do id um módulo à partir de seu nome
     * @param  [type] $modelTableName [description]
     * @return [type] [description]
     */
    public static function getModuleId($modelTableName)
    {
        if (phpversion() >= 5.4) {
            return $modelTableName::moduleId;
        } else {

            $class =  new \ReflectionClass($modelTableName);
            $metaConstants =  $class->getConstants();

            return $metaConstants["moduleId"];
        }
    }

    /**
     * retona uma lista de todas as tabelas existentes
     * @return [type] [description]
     */
    public function getTablesList()
    {
        $model = new \AckCore\Model\Systems;
        $tmp = $model->run("SHOW TABLES;");

        $result = null;
        foreach ($tmp as $element) {
            $result[] = $element["Tables_in_".self::getDatabaseName()];
        }

        return $result;
    }

    /**
     * retorna os nomes de tableas que iniciam com determinado prefixo
     * @param  [type] $namespace [description]
     * @return [type] [description]
     */
    public static function getTableNamesFromNamespace($namespace)
    {
        if(empty($namespace))
            throw new \Exception("Passe um namespace!", 1);

        $obj = new self;
        $tables = $obj->getTablesList();

        foreach ($tables as $key => $table) {
            if(!preg_match("/^$namespace.*$/", $table))
                unset($tables[$key]);
        }

        return $tables;
    }

    /**
     * retona o nome da tabela atual
     * @return [type] [description]
     */
    public static function getDatabaseName()
    {
        $model = new \AckCore\Model\Systems;
        $tmp = $model->run("SELECT DATABASE();");

        return $tmp[0]['DATABASE()'];
    }

    public static function getInstance()
    {
        return new self;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getAllTablesNames($model = null)
    {
        if (!$model) {
            $model = $this->getServiceLocator()->get('GenericTableModel');
        }

        $resultSet = $model->run('SHOW TABLES');

        $result = array();

        $dbName = $this->getServiceLocator()->get('Config');
        $dbName = $dbName['db']['dbname'];

        foreach ($resultSet as $key => $entry) {

            $result[$key] = $entry['Tables_in_'.$dbName];
        }

        return $result;
    }

    public function getColumnsNames($model)
    {

        $schema = $model->getSchema();

        $result = array();

        foreach ($schema as $key => $columnSchema) {
            $result[$key] = $columnSchema['Field'];
        }

        return $result;
    }

}
