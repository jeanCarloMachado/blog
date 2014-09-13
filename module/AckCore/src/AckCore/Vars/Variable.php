<?php
/**
 * representa uma variável do sistema
 *
 * descrição detalhada
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

namespace AckCore\Vars;
class Variable
{
    /**
     * valor bruto da coluna no banco de dados
     * @var unknown
     */
    public $bruteValue = null;
    /**
     * valor da coluna no banco de dados (modificado como consta em vartypes)
     * @var unknown
     */
    public $value = null;
    /**
     * tipo da coluna no banco de dados
     * @var unknown
     */
    public $type = null;
    /**
     * nome da coluna no banco de dados
     * @var unknown
     */
    public $columnName;
    /**
     * apelido da coluna a ser mostrado
     * @var unknown
     */
    public $colNick;

    /**
     * nome do modelo de tabela da coluna
     * @var unknown
     */
    public $table;

    protected static $helperClasses = array (
        '\\AckCore\\Utils\\Money',
        '\\AckCore\\Utils\\Date',
        '\\AckCore\\Utils\\String',
    );

    /**
     * mostra o valor formatado de acordo com o tipo especificado
     * @return [type] [description]
     */
    public function getValue()
    {
        if($this->value)

            return $this->value;

        if(!$this->type)
            $this->setType();

        return $this->type->convert($this->bruteValue);
    }

    public function setColumnName($name)
    {
        $this->columnName = $name;
    }

    public function getColumnName()
    {
        return $this->columnName;
    }

    public function getColName()
    {
        return $this->columnName;
    }

    public function getVal($params = null)
    {
        if ($params != null) {

            if (is_bool($params) && $params) {
                return $this->getColNick().': '.$this->getValue();
            } elseif (is_string($params)) {
                return $params.': '.$this->getValue();
            }

        }

        return $this->getValue();
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getBruteValue()
    {
        return $this->bruteValue;
    }

    public function setBruteValue($value)
    {
        $this->bruteValue = $value;

        return $this;
    }

    public function getBruteVal()
    {
        return $this->bruteValue;
    }

    public function setBruteVal($value)
    {
        $this->bruteValue = $value;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type=null)
    {
        $this->type = \AckCore\Vars\TypeMgr::getInstance($type,$this);

        return $this;
    }

    /**
     * retorna o nickname da coluna em
     * questão
     */
    public function getColNick()
    {
        /**
         * se o nickname da coluna estiver
         * vazio, então o objeto buscará no modelo
         * o nome correto
         */
        if (empty($this->colNick)) {

            $modelName = $this->getTable();

            if(!$modelName)
                throw new \Exception("para pegar um nickname não setado manualmente
                                    é necessário que o nome do modelo esteja setado com setTable, esteja
                                    exceção pode ocorrer quanado o nome do elemento não está corretamente setado
                                    NOME ATUAL [".$this->value."]");
            $model = new $modelName;
            $this->colNick = $model->getColNick($this->getColName());
        }

        return $this->colNick;
    }

    public function getAlias()
    {
        return $this->getColNick();
    }

    public function setColNick($nick)
    {
        $this->colNick = $nick;

        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($nick)
    {
        $this->table = $nick;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getBruteVal(); 
    }

    public function __call($name, $arguments)
    {
        foreach (self::$helperClasses as $className) {

            //testa se existe método estático
            if (method_exists($className, $name)) {

                $class = $className;

                if (empty($arguments)) {
                    $arguments[] = $this->getBruteVal();
                } else {
                    $argumentsBkp = $arguments;
                    $arguments = array();
                    $arguments[] = $this->getBruteVal();
                    $arguments = array_merge($arguments, $argumentsBkp);
                }

                $this->setValue(call_user_func_array(array($class, $name), $arguments));

                return $this;
            } else {

                $class = new $className;

                if (method_exists($class,$name)) {
                    if (empty($arguments)) {
                        $arguments[] = $this->getBruteVal();
                    } else {
                        $argumentsBkp = $arguments;
                        $arguments = array();
                        $arguments[] = $this->getBruteVal();
                        array_merge($arguments,$argumentsBkp);
                    }

                     $this->setValue(call_user_func_array(array($class, $name), $arguments));

                    return $this;
                }
            }
        }

       throw new \Exception("Não foi possível encontrar a função  $name, nem na classe, nem em seus helpers", 1);
    }
}
