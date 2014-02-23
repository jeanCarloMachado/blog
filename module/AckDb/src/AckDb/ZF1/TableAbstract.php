<?php
/**
 * abstrai uma tabela do banco de dados no padrão zend framework 1
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
namespace AckDb\ZF1;

use AckCore\Event\Event;
use AckDb\Model\DDL;
use AckCore\Observer\Traits\Observable;
use AckCore\ServiceLocator\Traits\ServiceLocatorAware;
/**
 * abstrai uma tabela do banco de dados no padrão zend framework 1
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
abstract class TableAbstract extends ZendTableAbstract implements TableInterface
{
    use Observable;
    use ServiceLocatorAware;

    //###################################################################################
    //################################# atributos###########################################
    //###################################################################################

    const moduleName = null;

    /**
     * nome da tabela no banco de dados
     * @var [type]
     */
    protected $_name;

    /**
     * obeto de retorno dos selects
     * @var [type]
     */
    protected $_row;

    /**
     * linha global que n��o
     * deve ser reescrito na classe
     * mas dinamicamente para
     * sobreescrever a linha atual
     * a ser retornada nos m��todos
     * toObject
     * @var string
     */
    protected static $tmpRow = null;
    protected $_rowObj;

    /**
     * ultimo sql executado
     * @var [type]
     */
    protected $_query = null;

    /**
     * filtros b��sicos para serem executados
     * sempre que o servico estiver habilitado
     * @var [type]
     */
    protected $_filter = array();
    protected $_filterStatus = 0;

    /**
     * flag de query do sistema
     * @var integer
     */
    protected $_sysQuery = 0;
    protected $alias = "sem apelido";

    /**
     * observadores
     * @var [type]
     */
    protected $onlyNotDeleted = 1;

    /**
     * flag que retorna o objeto
     * @var integer
     */
    protected $_returnObj = 0;
    protected $visibleCol;

    protected $relations;
    protected $meta;

    /**
     * colunas (default) usadas em funcionalidades do
     * sitema
     * @var unknown
     */
    protected $functionColumns = array(

                //utilizado na fun����o onlyAvailable e nos controladores do ack (status vis��vel)
                "visible" => array (
                                    "name"=>"visivel",
                                    "enabled"=>"1",
                                    "disabled"=>"0"
                                  ),
                //utilizado na fun����o onlyAvailable e onlyNotDeleted
                "status" => array (
                                    "name"=>"status",
                                    "enabled"=>"1",
                                    "disabled"=>"9"
                                    ),
                "order" => "ordem DESC"
    );

    /**
     * nessa varia��vel v��o os apelidos das colunas
     * @var unknown
     */
    protected $colsNicks = null;

    /**
     * cache da funçao get schema
     * @var unknown
     */
    protected $schemaCache = null;
    //###################################################################################
    //################################# END atributos########################################
    //###################################################################################
    //###################################################################################
    //################################# funcionalidades internas do sistema ###########################################
    //###################################################################################

    public function __construct()
    {
        parent::__construct();

        $this->_db->getProfiler()->setEnabled(true);

        $this->onlyAvailable = null;
        $this->_queryType = null;

        //adiciona o observer de ordem
        $this->attach("AckDb\ZF1\Observer\UpdateOrder");

    }
    /**
     * run interno (nao salva log)
     * execuata um sql qualquer
     * @param unknown $sql
     */
    protected function _run($sql)
    {
        $stmt = $this->_db->query($sql);
        $result = $stmt->fetchAll();
        $this->_setQuery($sql);

        /**
         * notifica o ocorrido
        */
        if (!$this->_isSysQuery()) {
            if ($this->toObjectEnabled()) {
                $className =$this->getRowName();
                $result = $className::Factory($result,$this->getRowName());
                // $result = @call_user_func(array($this->getRowName(),'Factory'),$result,$this->getRowName());

                /** desativa o to object */
                $this->setToObjectEnabled(!$this->toObjectEnabled());
            }
        } else {
            $this->_disableSysQuery = 0;
        }

        return $result;
    }
    /**
     * get interno (não guarda o tipo da query)
     * @param array  $where
     * @param string $params
     * @param string $columns
     */
    protected function _get(array $where=null,$params=null,$columns=null)
    {
        //inicializacao de variáveis
        $order = null;
        $count = null;
        $offset = null;

        //testes iniciais
        //se nao foi passado nenhuma cláusula de ordem
        //pega a default do sistema
        $order = (!empty($params["order"])) ? $params["order"] : $this->getOrder();

        /**
         * total de eleemtnos a buscar
         * @var [type]
         */
        if(!empty($params["limit"]["count"])) $count = $params['limit']['count'];
        /**
         * à partir de qual elemento buscar
         * @var [type]
         */
        if(!empty($params["limit"]["offset"])) $offset = $params['limit']['offset'];

        $this->_prepareFilter($where);

        if($this->getOnlyAvailable()) $this->onlyAvailableQuerySetup($where);
        if($this->getOnlyNotDeleted()) $this->onlyNotDeletedQuerySetup($where);

        $where = $this->atribution($where);

        if (!empty($where)) {
            foreach ($where as $elementId => $element) {
                $hasInterogationChar = $this->hasInterogationChar($elementId);

                if ($hasInterogationChar) {
                    continue;
                } else {
                    $comparationChar = $this->hasComparationChar($elementId);
                    /** se não há caractere de comparacao na query,
                     coloca o default e remove a chave antiga,
                     caso o contrário deixa-o como veio
                    **/
                    if (!$comparationChar) {
                        $where[$elementId.' = ?'] = $element;
                    } else {
                        $where[$elementId.' ?'] = $element;
                    }
                    unset($where[$elementId]);
               }
            }
        }
        //monta a query conforme a especificaçã do zend
        $select = $this->select();

        if ($where !== null) {
            $this->_where($select, $where);
        }

        if ($order !== null) {
            $this->_order($select, $order);
        }

        if ($count !== null || $offset !== null) {
            $select->limit($count, $offset);
        }

        if (isset($params["getQuery"])) {
              \AckCore\Utils::sw($select->assemble());
              die;
        }

        try {
            $result = $this->fetchAll($select);
        } catch (\Exception $e) {
            throw new \Exception("Ocorreu um erro com a consulta que segue no modelo < ".get_called_class()." > : \n".$select->assemble());
        }

        //retorno
        return $result;
    }

    /**
     * retorna o nome da coluna ordem
     * que está setado em $functionColumns
     */
    public function getOrderColumnName()
    {
        $result = null;

        if (!empty($this->functionColumns["order"])) {
            $tmp = explode(" ",$this->functionColumns["order"]);
            $result=  reset($tmp);
        }

        return $result;
    }
    /**
     * retorna o campo ordem
     * setado em $funcionColumns
     */
    public function getOrder()
    {
        //existe o campo default de ordem na tabela
        //ele ordena por este
        if($this->hasColumn($this->getOrderColumnName())) return $this->functionColumns["order"];

        return "id ASC";
    }
     /**
     * quando habilitado o sistema sabe que é uma
     * query interna e desabilita vários serviços como log
     * @return [type] [description]
     */
    protected function _enableSysQuery()
    {
        $this->_sysQuery = 1;
    }
    /**
     * desabilita a flag de query do sistema
     * @return [type] [description]
     */
    protected function _disableSysQuery()
    {
        $this->_sysQuery = 0;
    }
    /**
     * retorna true se for uma query do sistema que
     * há ou está sendo executada
     * @return boolean [description]
     */
    protected function _isSysQuery()
    {
        return $this->_sysQuery;
    }
    /**
     * seta a query que há de ser excutada
     * @param [type] $sql [description]
     */
    protected function _setQuery($sql = null)
    {
        if($sql) $this->_query = $sql;
        else $this->_query = ($this->_db->getProfiler()->getLastQueryProfile()->getQuery());
        return $this;
    }

    public function getQuery()
    {
        return $this->_query;
    }

    public function getVisibleCol()
    {
        if(empty($this->functionColumns["visible"]))

        return array (
                      "name"=>"visivel",
                      "enabled"=>"1",
                      "disabled"=>"0"
                      );

        return $this->functionColumns["visible"];
    }

    public function getVisibleColName()
    {
        if(empty($this->functionColumns["visible"])) return "visivel";

        return $this->functionColumns["visible"]["name"];
    }

    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * da merge do where com as query's
     * dos disponiveis
     * @param unknown $where
     */
    protected function onlyAvailableQuerySetup(&$where)
    {
        $avilableArr = array();

        if (!empty($this->functionColumns["status"])) {
            $avilableArr[$this->functionColumns["status"]["name"]] = $this->functionColumns["status"]["enabled"];
        }

        if (!empty($this->functionColumns["visible"])) {
            $avilableArr[$this->functionColumns["visible"]["name"]] = $this->functionColumns["visible"]["enabled"];
        }

        $where = array_merge((array) $avilableArr,(array) $where);
        $this->setOnlyAvailable(false);

        return true;
    }
    /**
     * da merge do where com as query's
     * dos disponiveis
     * @param unknown $where
     */
    protected function onlyNotDeletedQuerySetup(&$where)
    {
        $notDeletedArr = array();

        if (!empty($this->functionColumns["status"])) {
            $notDeletedArr[$this->functionColumns["status"]["name"]] = $this->functionColumns["status"]["enabled"];
        }

        $where = array_merge((array) $notDeletedArr,(array) $where);
        $this->onlyNotDeleted = false;

        return true;
    }

    public function toObjectEnabled()
    {
        return $this->_returnObj;
    }

    protected function setToObjectEnabled($status)
    {
        $this->_returnObj = $status;

        return $this;
    }
    /**
     * reseta a query para suas configura����es default
     * @return [type] [description]
     */
    public function resetToQueryDefaults()
    {
        $this->_returnObj = 0;
        $this->queryType = null;
    }

    protected function _queryType()
    {
        return $this->_queryType;
    }

    /**
     * ativa o servico de filtros
     * basicos e retorna o objeto configurado
     * @param  [type] $status [description]
     * @return [type] [description]
     */
    public function useFilter()
    {
        $this->_filterStatus = 1;

        return $this;
    }

    public function disableFilter()
    {
        $this->_filterStatus = 0;

        return $this;
    }

    /**
     * adiciona filtros básicos da classe no
     * where a ser executado, depois desativa o filtro
     * @return [type] [description]
     */
    protected function _prepareFilter(&$where)
    {
        /**
         * desabilita o serviços para as proximas querys
         */
        if(!$this->_filterStatus) return false;

        $this->disableFilter();

        if(!is_array($where)) $where = array();

        foreach ($this->_filter as $filterId => $filter) {
            $where[$filterId] = $filter;
        }

        return true;
    }

    public function factoryChilds($array)
    {
        if(!$array)	throw new \Exception("nenhuma linha em array passada para a criaçao dos modelos em objetos");
        //chama o método estático à partir de um objeto variável
        return call_user_func(array($this->getRowName(),'Factory'),$array,$this->getRowName());
    }

    /**
     * testa existe algum elemento de comparacao,
     * caso exita, retorna a string sem ele.
     * caso não, retorna null
     * @param  [type]  $str [description]
     * @return boolean [description]
     */
    protected function hasComparationChar($str)
    {
        $str = explode(' ',$str);
        $result = (count($str) > 1) ? $str : null;

        return $result;
    }

    protected function hasInterogationChar($str)
    {
        if(preg_match("/^.*\?.*$/", $str)) return true;

        return false;
    }

    /**
     * testa os tipos e atribui aspas aos elemetnos que entram no esquema coluna=>valor
     * @param  [array] $array [description]
     * @return [array] [description]
     */
    public function atribution(&$array)
    {
        $tableSchema = $this->getSchema();

        if(empty($array))

            return null;

        foreach ($array as $columnName => $columnValue) {
            $hasColumn = false;
            foreach ($tableSchema as $idColumnSchema => $valuesSchema) {
                /**
                 * testa se há algum caracter de comparação, caso exista
                 * o remove da query
                 * @var [type]
                 */
                $columnName = ($this->hasComparationChar($columnName)) ? $columnName[0] : $columnName;

                //retorna se existe a coluna ou não
                if(
                    $valuesSchema['Field'] == $columnName
                    || "LOWER(".$valuesSchema['Field'].")" == $columnName
                    || "DATE(".$valuesSchema['Field'].")" == $columnName
                    || "MONTH(".$valuesSchema['Field'].")" == $columnName
                    || "YEAR(".$valuesSchema['Field'].")" == $columnName
                    || "DATE(".$valuesSchema['Field'].") between " == $columnName
                    //|| "".$valuesSchema['Field']." IN (?)" == $columnName
                ) 	{

                    $hasColumn = true;
                    break;
                }
            }
            /**
             * caso a coluna nao exista no esquema
             * a remove
             */
            if(!$hasColumn)
                unset($array[$columnName]);
        }

        return $array;
    }
    //###################################################################################
    //################################# END funcionalidades internas do sistema ########################################
    //###################################################################################
    //###################################################################################
    //################################# sqls para o usuário ###########################################
    //###################################################################################

    /**
     * cria uma linha no banco de dados recebendo um
     * array com suas colunas
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set,array $params=null)
    {
        if (!empty($params)) {
            /**
             * ###################################################################################
             * caso o parâmetro createNotFoundColumns é passado, o sistema criará as colunas
             * que não existirem na tabela mas existirem no set;
             *###################################################################################
             * @author Jean Carlo Machado <j34nc4rl0@gmail.com>
             */
            if(isset($params["createNotFoundColumns"]) && ($params["createNotFoundColumns"] == true))
                $ddl = new DDL();
                foreach ($set as $col => $value) {
                    $ddl->addColumn($col,$this);
                }
        }

        $returnInObject = ($this->toObjectEnabled()) ? true : false;

        $set = $this->atribution($set);
        $this->insert($set);
        $this->_setQuery();
        $query = $this->getQuery();

        $result = $this->getLastId();

        {
            /**
             * notifica o ocorrido
             */
            $container = new Event();
            $container->setSet($set)
            ->setType(\AckCore\Event\Event::TYPE_ROW_CREATED)
            ->setAction("create")
            ->setQuery($query)
            ->setResult(array($result))
            ->setModel($this)
            ->setTable($this->getTableName());
            $this->notify($container);
        }

        if(is_array($result) && count($result) == 1) $result = reset($result);

        if ($returnInObject) {
            $result = $this->getOne(array("id"=>$result));
            $this->resetToQueryDefaults();
        }

        return $result;
    }

    /**
     * faz a consulta ao banco de dados
     * @param  [type] $array  [description]
     * @param  [type] $params [description]
     * @return [type] [description]
     */
    public function get(array $where=null,$params=null,$columns=null)
    {

        $result = $this->_get($where,$params,$columns);

        $rowName = $this->getRowName();

        //pega as linhas em forma de objetos caso as mesmas tennham sido chamadas dessa forma
        if ($this->toObjectEnabled()) {
            /**
             * ###################################################################################
             * layer de compatibilidade entre o php 5.4 e o 5.3 somente um dos dois é incluido,
             * resultando em sintaxes corretas automaticamente.
             *###################################################################################
             * @author Jean Carlo Machado <j34nc4rl0@gmail.com>
             */
            if (phpversion() >= 5.4) {
                $result = include 'components/54.php';
            } else {
                $result = include 'components/53.php';
            }

        }

        if ($this->_queryType == 'get') {
            $this->resetToQueryDefaults();
        }
        /**
         * salva o tipo da query
         */
        $this->_setQuery();

        return $result;
    }

    /**
     * retorna um e somente um objeto através de uma cláusula
     * where, caso mais sejam encontrados uma exceção é lançada
     * @param  [type] $where   [description]
     * @param  [type] $params  [description]
     * @param  [type] $columns [description]
     * @return [type] [description]
     */
    public function getOne(array $where=null,$params=null,$columns=null)
    {
        if (!empty($where)) {
            $result = $this->get($where,$params,$columns);
        }

        if (empty($result)) {
            $rowName = $this->getRowName();

            return new $rowName;
        } elseif (count($result) > 1) {
            \AckDevel\Debug\Debug::sw($result);
            throw new \Exception("mais de um valor retornado");
        }

        return reset($result);
    }

    /**
     * tenta atualizar um objeto através do where, caso nenhum
     * objeto seja encontrado, então o sistema cria um novo com
     * as colunas passadas em set
     * @param  array  $set    [description]
     * @param  array  $where  [description]
     * @param  [type] $params [description]
     * @return [type] [description]
     */
    public function updateOrCreate(array $set,array $where,$params=null)
    {
        $result = null;
        if(empty($where) || \AckCore\Utils\Arr::allElementsEmpty($where)) return $this->create($set);

        $resultGet = $this->get($where);

        if(empty($resultGet)) $result = array($this->create($set));
        else $result = $this->update($set,$where);

        if(empty($result)) $result =& $resultGet;

        return $result;
    }

    /**
     * detela uma ou mais linhas de acordo
     * com a cláusula where passada
     * @param  [type] $where [description]
     * @return [type] [description]
     */
    public function delete($where)
    {
        $this->_prepareFilter($where);
        $where = $this->atribution($where);

        foreach ($where as $elementId => $element) {
            $where[$elementId.' = ?'] = $element;
            unset($where[$elementId]);
        }
        $result = parent::delete($where);
        $this->_setQuery();
        $query = $this->getQuery();

        /**
         * notifica o ocorrido
         */
        $container = new Event();
        $container->setSet($where);
        $container->setQuery($query);
        $container->setResult($result);
        $container->setModel($this);
        $this->notify($container);

        return $result;
    }

    public function purge(array $where) {}

    public function virtualDelete($where)
    {
        return $this->update(array("status"=>"0"),$where);
    }

    /**
     * da um update de uma(s) linha(s) de acordo com a
     * cláusula where passada
     * @param  array  $set   [description]
     * @param  [type] $where [description]
     * @return [type] [description]
     */
    public function update(array $set,$where)
    {
        $cleanSet = $set;
        $cleanWhere = $where;
        $this->_prepareFilter($where);
        /**
         * salva-se o where limpo para posterior consulta
         * @var [type]
         */
        $cleanWhere = $where;
        $this->atribution($set);
        $this->atribution($where);

        foreach ($where as $elementId => $element) {

            $where[$elementId.' = ?'] = $element;
            unset($where[$elementId]);
        }

        //pega os valores antigos para o notify
        $prevResult = $this->_get($cleanWhere);
        /**
         * executa o update
         */
        $resultUpdate = parent::update($set,$where);
        $this->_setQuery();
        $query = $this->getQuery();

        if(!($resultUpdate))

            return false;
        /**
         * consulta os itens modificados
         * @var [type]
         */
        $resultGet = $this->_get($cleanWhere);

        $result = array();
        foreach ($resultGet as $elementId => $element) {
            $result[$elementId] = $element['id'];
        }
        /**
         * notifica o ocorrido
         */
        $container = new Event();
        $container->setPrevVals($prevResult)
        ->setAction("update")
        ->setQuery($query)
        ->setResult($result)
        ->setModel($this)
        ->setTable($this->getTableName());
        $this->notify($container);

        if(count($result) == 1)

            return reset($result);

        return $result;
    }

    /**
     * retorna o ultimo id inserido
     * @return [type] [description]
     */
    public function getLastId()
    {
        $sql = 'SELECT LAST_INSERT_ID()';
        $result = $this->_db->fetchAll($sql);
        $result = $result[0]['LAST_INSERT_ID()'];

        return $result;
    }

    /**
     * @return [type] [description]
     */
    public function count($where = null)
    {
        if (is_array($where)) {
            if($this->getOnlyAvailable())
                $this->onlyAvailableQuerySetup($where);
            $result = $this->get($where);

            return count($result);
        }

        if(!empty($where))
            $where =  " WHERE ".$where;

        $result = $this->run("SELECT COUNT(*) from ".$this->getTableName().$where);

        return $result[0]['COUNT(*)'];
    }

    /**
     * executa um sql qualquer
     * @param  [type] $sql [description]
     * @return [type] [description]
     */
    public function run($sql)
    {
        $result = $this->_run($sql);

        $container = new Event;
        $container->setQuery($sql);
        $container->setResult($result);
        $container->setModel($this);
        $this->notify($container);

        return $result;
    }

    /**
     * retorna todas as linhas do moduleo
     * @return [type] [description]
     */
    public static function getAll($parameters = null)
    {
        $className = get_called_class();
        $obj = new $className;
        $result = $obj->onlyAvailable()->toObject()->get(array(),$parameters);

        return $result;
    }

    /**
     * retorna todas as linhas do moduleo
     * @return [type] [description]
     */
    public static function staticGet($where)
    {
        $className = get_called_class();
        $obj = new $className;
        $result = $obj->onlyAvailable()->toObject()->get($where);

        return $result;
    }

    /**
     * retorna todos os elementos menos o especificado
     * @param  [type] $element [description]
     * @return [type] [description]
     */
    public static function getAllDifferentFrom($element)
    {
        $result = null;
        $id = null;
        if(is_int($element)) $id = $element;
        else throw new \Exception("Função suporta somente o id do elmeento sendo um inteiro");

        $className = get_called_class();
        $obj = new $className;
        $result = $obj->onlyAvailable()->toObject()->get(array("id !=" => $id));

        return $result;
    }

    /**
     * retorna um objeto à partir de seu id
     * @param  [type] $id [description]
     * @return [type] [description]
     */
    public static function getFromId($id)
    {
        $modelName = get_called_class();
        $model = new $modelName;
        $result =  $model->toObject()->getOne(array("id"=>$id));

        if (empty($result)) {
            $rowName = $model->getRowName();

            return new $rowName;
        }

        return $result;
    }

    //###################################################################################
    //################################# END sqls para o usuário ########################################
    //###################################################################################
    //###################################################################################
    //################################# funções para o usuário ###########################################
    //###################################################################################
    /**
     * retorna  o tipo de coluna de determinada coluna no banco de dados
     * @param  [type]  $columnIdentifier [description]
     * @param  boolean $literalSearch    [description]
     * @return [type]  [description]
     */
    public function getColumnType($columnIdentifier,$literalSearch = false)
    {
        $schema = $this->getColumnSchema($columnIdentifier,$literalSearch);
        $schema = reset($schema);

        return $schema["Type"];
    }

    /**
     * retorna o esquema de uma coluna no banco de dados
     * @param  [type]  $columnIdentifier [description]
     * @param  boolean $literalSearch    [description]
     * @return [type]  [description]
     */
    public function getColumnSchema($columnIdentifier,$literalSearch=false)
    {
        assert(0,"a busca literal não foi imeplemetada");
        foreach ($this->getSchema() as $key => $element) {
            if (preg_match("/$columnIdentifier.*/", $element["Field"])) {
                $result[$key] = $element;

                return $result;
            }
        }

        return array();
    }

    /**
     * adiciona a query que se suceder
     * cláusulas de status=1 e visível=1 para assegurar
     * que a busca encontre somente elementos não deletados e visíveis
     * @return [type] [description]
     */
    public function onlyAvailable()
    {
        $this->onlyAvailable = true;

        return $this;
    }

    /**
     * adiciona a query que se suceder
     * cláusulas de status=1 para assegurar
     * que a busca encontre somente elementos não deletados
     * @return [type] [description]
     */
    public function onlyNotDeleted()
    {
        $this->onlyNotDeleted = true;

        return $this;
    }

    /**
     * retorna um objeto em vez de retornar array
     * @return [type] [description]
     */
    public function toObject()
    {
        $this->_returnObj = 1;

        return $this;
    }

    /**
     * retorna uma instância mas não guarda esta
     * útil para não precisar dar new guardando em variável
     * @return [type] [description]
     */
    public static function getInstance()
    {
        $class = get_called_class();
        $class = "\\".$class;

        return new $class;
    }

    /**
     * testa se existe uma coluna no banco com o nome passado
     * @param  unknown $columnName
     * @return boolean
     */
    public function hasColumn($columnName, $ignoreCache = false)
    {
        if ($ignoreCache || !$this->schemaCache) {
            $this->schemaCache = $this->getSchema();
        }

        foreach ($this->schemaCache as $col) {
            if($columnName == $col["Field"])

                return true;
        }

        return false;
    }

    /**
     * retona o nome do objeto qeu deve ser retornado)
     *
     */
    public function getRowName()
    {
        if(!empty(self::$tmpRow))

            return self::$tmpRow;

        return $this->_row;
    }

    /**
     * retorna uma instância do objeto tipo linha
     * @return [type] [description]
     */
    public function getRowInstance()
    {
        $name = "";

        if(!empty(self::$tmpRow)) $name =  self::$tmpRow;

        $name =  $this->_row;

        return new $name;
    }

    /**
     * retorna o primeiro elemento de uma tabela em objeto
     */
    public static function getFirst()
    {
        $moduleName = get_called_class();
        $model = new $moduleName;
        $result = $model->toObject()->onlyAvailable()->get(array(),array("limit"=>array("count"=>1)));
        $result = reset($result);

        //se o resultado for vazio  retorna-se então um objeto do tipo adequado vazio
        if (empty($result)) {
            $rowModel = $model->getRowName();
            $result = new $rowModel();
        }

        return $result;
    }

    /**
     * retorna o último elemento da tabela em objeto
     * @return [type] [description]
     */
    public static function getLast()
    {
        $moduleName = get_called_class();
        $model = new $moduleName;
        $result = $model->toObject()->onlyAvailable()->get(array(),array("limit"=>array("count"=>1),"order"=>"id DESC"));
        $result = reset($result);

        //se o resultado for vazio  retorna-se então um objeto do tipo adequado vazio
        if (empty($result)) {
            $rowModel = $model->getRowName();
            $result = new $rowModel();
        }

        return $result;
    }

    public static function getDefault()
    {
        return self::getFirst();
    }

    //###################################################################################
    //################################# END funçoes para o usuário ########################################
    //###################################################################################
    //###################################################################################
    //################################# funcionalidades para o usuário, todavia bem menos comuns###########################################
    //###################################################################################
    /**
     * quando deseja-se tornar um modelo representante de outra
     * tabela, para uma query por exemplo, utiliza-se esta função
     * @param [type] $name [description]
     */
    public function setTmpRowName($name)
    {
        self::$tmpRow = $name;

        return $this;
    }

    /**
     * reseta o nome temporário a ser retonado
     * @return System_Db_Table_Abstract
     */
    public function rollbackTmpName()
    {
        self::$tmpRow = null;

        return $this;
    }

    /**
     * pega o apelido de uma coluna por seu
     * nome no banco de dados
     * @param unknown $colName
     */
    public function getColNick($colName)
    {
        $result = null;

        if(isset($this->colsNicks) && !empty($this->colsNicks[$colName]))
            $result = $this->colsNicks[$colName];

        //tenta encontrar alguma coluna quando colName foi
        //usado sem o idioma

        if(empty($result) && is_array($this->colsNicks))
        foreach ($this->colsNicks as $literalName => $nick) {

            $newName = (\AckCore\Utils\String::matchWithoutSuffixes($colName,$literalName));

            if (!empty($newName)) {
                $result = $this->colsNicks[$newName];
                break;
            }
        }
        if(empty($result))
            $result = \AckCore\Utils\String::humanizeDbName(/*\AckCore\Language\Language::translate*/($colName));

        return $result;
    }

    /**
     * retorna o objeto com maior valor de ordem
     * @return [type] [description]
     */
    public function getMajorOrderObject()
    {
        if(!$this->hasColumn("ordem"))
            throw new \Exception("O elemento não possui coluna ordem");

        $greaterOrderElement = $this->toObject()->get(null,array("limit"=>array("count"=>1),"order"=>"ordem DESC"));
        $greaterOrderElement = reset($greaterOrderElement);

        return $greaterOrderElement;
    }

    /**
     * retorna o objeto com menor valor de ordem
     * @return [type] [description]
     */
    public function getMinorOrderObject()
    {
        if(!$this->hasColumn("ordem"))
            throw new \Exception("O elemento não possui coluna ordem");

        $greaterOrderElement = $this->toObject()->get(null,array("limit"=>array("count"=>1),"order"=>"ordem ASC"));
        $greaterOrderElement = reset($greaterOrderElement);

        return $greaterOrderElement;
    }

    /**
     * retorna o esquema da tabela no banco de dados
     * @return [type] [description]
     */
    public function getSchema()
    {
        $this->_enableSysQuery();
        $sql = "DESCRIBE `".$this->getName()."`";
        $result = $this->_run($sql);

        return $result;
    }

    //###################################################################################
    //################################# END funcionalidades para o usuário, todavia bem menos comuns########################################
    //###################################################################################
    //###################################################################################
    //################################# getters & setters###########################################
    //###################################################################################

    public function disableOnlyNotDeleted()
    {
        $this->onlyNotDeleted = 0;

        return $this;
    }

    public function getOnlyNotDeleted()
    {
        return $this->onlyNotDeleted;
    }

    public function setOnlyNotDeleted($onlyNotDeleted)
    {
        $this->onlyNotDeleted = $onlyNotDeleted;

        return $this;
    }
    public function setOnlyAvailable($status=false)
    {
        $this->onlyAvailable = $status;

        return $this;
    }
    /**
     * @return [type] [description]
     */
    public function getOnlyAvailable()
    {
        return $this->onlyAvailable;
    }

    /**
     * retorna o nome da tabela no banco de dados
     * @return [type] [description]
     */
    public function getName()
    {
        return $this->getTableName();
    }

    /**
     * seta o nome da tabela no banco de dados
     * @param [type] $name [description]
     */
    public function setName($name)
    {
        $this->setTableName($name);

        return $this;
    }

    /**
     * deprecated
     * retorna o nome da tabela no banco de dados
     * @return [type] [description]
     */
    public function getTableName()
    {
        return $this->_name;
    }

    /**
     * deprecated
     * seta o nome da tabela no banco de dados
     * @param [type] $tableName [description]
     */
    public function setTableName($tableName)
    {
        $this->_name = $tableName;

        return $this;
    }

    /**
     * retorna os apelidos das colunas (caso existam)
     * @return unknown
     */
    public function getColsNicks()
    {
        if(empty($this->colsNicks))

            return null;
        return $this->colsNicks;
    }

    /**
     * seta os apelidos de colunas
     * @param [type] $colsNicks [description]
     */
    public function setColsNicks($colsNicks)
    {
        $this->colsNicks = $colsNicks;

        return $this;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    public function setRelations($relations)
    {
        $this->relations = $relations;

        return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }
    //###################################################################################
    //################################# END getters & setters########################################
    //###################################################################################

    /**
     * cria chamadas dinâmicas
     * @param  [type] $method [description]
     * @param  array  $args   [description]
     * @return [type] [description]
     */
    public function __call($method, array $args)
    {
        $result = null;
        //trata de relacionamentotos N => N
        if ("getFromArrayOf" == substr($method, 0, 14)) {

            $colName = substr($method,14);
            $colElements = $args[0];
            $disableToObject = $args[1];

            return $this->getFromArrayOf($colName,$colElements,$disableToObject);
        }
        throw new \Exception("método desconhecido (".$method.") - verificar em  ExtendedTableAbstract");
    }
    /**
     * função do call para pegar elementos
     * à partir de um array de algo (ids,nomes,etc)
     * @return [type] [description]
     */
    protected function getFromArrayOf($colName,&$colElements,$disableToObject = false, $comparationChar="=")
    {
        $result = array();

        if(empty($colElements)) return $result;

        $query = "SELECT * FROM ".$this->getTableName()." WHERE 1=0 ";

        foreach ($colElements as $value) {
            $query.= " OR $colName $comparationChar $value";
        }
        $query = strtolower($query);
        $result = $this->_run($query);

        return $result;
    }

    /**
     * retorna o próximo id a ser inserido no banco de dados
     * @return [type] [description]
     */
    public function getNextId()
    {
        $last = $this->getLast();
        if(!$last->getId()->getBruteVal())

            return 1;
        else return ($last->getId()->getBruteVal());
    }

    public function newRowInstance()
    {
        $rowName = $this->_row;

        return new $rowName;
    }

    /**
     * retorna a configuração da relação à patir de um nome de colunal
     *
     * @param string $columnName nome da coluna no banco de dados (literal)
     *
     * @return array
     */
    public function getRelationConfigFromColumnName($columnName)
    {
        if (empty($this->relations)) return null;

        foreach ($this->relations as $type) {

            foreach ($type as $realRelation) {

                if ($realRelation['reference'] == $columnName) {
                    return $realRelation;
                }
            }
        }
    }
    /**
     * retorna a configuração da relação à patir de um nome de colunal
     *
     * @param string $columnName nome da coluna no banco de dados (literal)
     *
     * @return array
     */
    public function getRelationConfigFromModelName($modelName)
    {
        if (empty($this->relations)) return null;

        foreach ($this->relations as $type) {

            foreach ($type as $realRelation) {

                if ($realRelation['model'] == $modelName) {
                    return $realRelation;
                }
            }
        }
    }

    /**
     * retorna um protótipo de um objeto de linha
     *
     * @return RowAbstract Objeto de linha
     */
    public function getRowPrototype()
    {
        return $this->toObject()->getOne();
    }
}
