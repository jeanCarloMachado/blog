<?php

/**
 * conversor de esquemas em db2 para mysql
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
 * @package   Ack
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */

namespace AckDb\Model;

use AckMvc\Model\BasicModel;

/**
 * converte schemas de db2 para mysql
 *
 * @category Client
 * @package  Portal
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Db2MysqlConverter extends BasicModel
{
    protected static $typesConvertion = array(
        'CHAR' => 'varchar (#size)',
        'DECIMAL' => 'decimal (20,2)',
    );

    /**
     * à partir de um schema de tabela em db2
     * retorna o sql de criação para mysql
     *
     * @param (array) $schema    esquema do banco
     * @param (array) $tableName nome da tabela do banco
     *
     * @return void
     */
    public function getCreateSqlFromSchema($schema,$tableName)
    {
        $preffix = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (';
        $sql = '';

        foreach ($schema as $column) {

            $type = null;
            //========================= adaptações para portal de relacionamentos =========================

            if ($column[3] == 'CLIENTE'
                || $column[3] == 'CNPJ_CPF'
                || $column[3] == 'CPFCNPJ_CLIENTE'
                || $column[3] == 'CUPOM'
                || $column[3] == 'ESTABELECIMENTO'
                || $column[3] == 'CODIGO_IMPRSSORA'
            ) {
                $type = 'varchar (50)';

            } elseif (strpos($column[3], 'DATA')) {
                $type = 'datetime';
            } else {

                $type = $this->getAdaptedColumnTypeFromColumnSchema($column);
            }
            //======================= END adaptações para portal de relacionamentos =======================

            $sql.= $column[3].' '.$type.', ';
        }

        $sql = strtolower($sql);

        $sql.= 'id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (id)';

        $sql.= ');';

        $sql = $preffix.$sql;

        return $sql;
    }

    /**
     * retorna o tipo da coluna no padrão mysql
     *
     * @param array $columnArray array de coluna de esquema db2
     *
     * @return void
     */
    protected function getAdaptedColumnTypeFromColumnSchema($columnArray)
    {
        $columnType = $columnArray[5];

        if (array_key_exists($columnType, static::$typesConvertion)) {
            $result = static::$typesConvertion[$columnType];

            return str_replace('#size', 100, $result);
        }

        return 'TEXT';
    }

    /**
     * transforma a saída do db2  em mysql
     *
     * @param array  $row       linhas do banco
     * @param string $tableName nome da tabela no banco de dados
     *
     * @return string o sql de inserção
     */
    public function getInsertSqlFromData($row, $tableName)
    {
        $sql = 'INSERT INTO '.$tableName.' VALUES ( ';

        foreach ($row as $key => $column) {

            $column = str_replace("'", '', $column);

            if (!is_numeric($column)) {
                $column = "'".$column."'";
            }

            $sql.= $column.',';
        }

        $sql.= ' null';
        $sql.= ');';

        return $sql;
    }
}
