<?php
/**
 * esta classe deve especificar como o modelo de tabelas
 * deve implementar suas interfaces
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
interface TableInterface
{
//###################################################################################
//################################# business methods ###########################################
//###################################################################################
/**
 * efetua uma consulta no banco de dados
 * @param  [type] $where   cláusula where
 * @param  [type] $params  parâmetros para modificar a query
 * @param  [type] $columns colunas para serem retornadas (caso vazio todas serão retornadas)
 * @return [type]          [description]
 */
public function get(array $where = null,$params = null,$columns = null);

/**
 * retorna um e somente um objeto através de uma cláusula
 * where, caso mais sejam encontrados uma exceção é lançada
 * @param  [type] $where   [description]
 * @param  [type] $params  [description]
 * @param  [type] $columns [description]
 * @return [type] [description]
 */
public function getOne(array $where = null,$params = null,$columns = null);

/**
 * tenta atualizar um objeto através do where, caso nenhum
 * objeto seja encontrado, então o sistema cria um novo com
 * as colunas passadas em set
 * @param  array  $set    [description]
 * @param  array  $where  [description]
 * @param  [type] $params [description]
 * @return [type] [description]
 */
public function updateOrCreate(array $set,array $where,$params=null);

/**
 * deleta as entradas com a cláusula where passada
 * ( na real o status da entrada é setado para 9 caso esta coluna exitir )
 * @param  [type] $where [description]
 * @return [type] [description]
 */
public function delete($where);

/**
 * deleta (realmente) as entradas do banco
 * @param  [type] $where [description]
 * @return [type] [description]
 */
public function purge(array $where);

/**
 * da um update de uma(s) linha(s) de acordo com a
 * cláusula where passada
 * @param  array  $set   [description]
 * @param  [type] $where [description]
 * @return [type] [description]
 */
public function update(array $set,$where);

/**
 * retorna o ultimo id inserido
 * @return [type] [description]
 */
public function getLastId();

/**
 * conta as linhas de uma  tabela de acordo com uma cláusula especificada
 * caso nenhuma clausula seja passada o sistema conta todas as linhas da
 * tabela.
 * @return [type] [description]
 */
public function count($where = null);

/**
 * executa um sql qualquer
 * @param  [type] $sql [description]
 * @return [type] [description]
 */
public function run($sql);

/**
 * retorna o esquema de uma coluna no banco de dados
 * @param  [type]  $columnIdentifier [description]
 * @param  boolean $literalSearch    [description]
 * @return [type]  [description]
 */
public function getColumnSchema($columnIdentifier,$literalSearch=false);

/**
 * adiciona a query que se suceder
 * cláusulas de status=1 e visível=1 para assegurar
 * que a busca encontre somente elementos não deletados e visíveis
 * @return [type] [description]
 */
public function onlyAvailable();

/**
 * adiciona a query que se suceder
 * cláusulas de status=1 para assegurar
 * que a busca encontre somente elementos não deletados
 * @return [type] [description]
 */
public function onlyNotDeleted();

/**
 * retorna um objeto em vez de retornar array
 * @return [type] [description]
 */
public function toObject();

/**
 * retorna uma instância mas não guarda esta
 * útil para não precisar dar new guardando em variável
 * @return [type] [description]
 */
public static function getInstance();

/**
 * testa se existe uma coluna no banco com o nome passado
 * @param  unknown $columnName
 * @return boolean
*/
public function hasColumn($columnName);

/**
* retona o nome da classe que representa uma
* linha desta tabela
*/
public function getRowName();

/**
 * retorna uma instância do objeto tipo linha
 * @return [type] [description]
 */
public function getRowInstance();

/**
 * retorna o esquema da tabela no banco de dados
 * @return [type] [description]
 */
public function getSchema();

/**
 * retorna o nome da tabela no banco de dados
 * @return [type] [description]
 */
public function getName();

//###################################################################################
//################################# END business methods ########################################
//###################################################################################
//###################################################################################
//################################# facilitadores ###########################################
//###################################################################################
/**
 * retorna todas as linhas do moduleo
 * @return [type] [description]
 */
public static function getAll();

/**
 * retorna todas as linhas do moduleo
 * @return [type] [description]
 */
public static function staticGet($where);

/**
 * retorna todos os elementos menos o especificado
 * @param  [type] $element [description]
 * @return [type] [description]
 */
public static function getAllDifferentFrom($element);

/**
 * retorna um objeto à partir de seu id
 * @param  [type] $id [description]
 * @return [type] [description]
 */
public static function getFromId($id);

/**
 * retorna o primeiro elemento de uma tabela em objeto
 */
public static function getFirst();

 /**
 * retorna o último elemento da tabela em objeto
 * @return [type] [description]
 */
public static function getLast();

/**
 * retorna e alinha em objeto default
 * do sistema (na implementação original retornava o primeiro (getFirst()))
 * @return [type] [description]
 */
public static function getDefault();

/**
 * retorna o objeto com maior valor de ordem
 * @return [type] [description]
 */
public function getMajorOrderObject();

/**
 * retorna o objeto com menor valor de ordem
 * @return [type] [description]
 */
public function getMinorOrderObject();

//###################################################################################
//################################# END facilitadores ########################################
//###################################################################################
//###################################################################################
//################################# getters and setters ###########################################
//###################################################################################

public function getQuery();

//###################################################################################
//################################# END getters and setters ########################################
//###################################################################################
}
