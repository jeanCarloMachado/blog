<?php
/**
 * classe abstrata que representa o retorno de uma linha do banco de dados
 * quanto for utilizado o método toObject()
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

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use AckCore\Facade;

/**
 * classe abstrata que representa o retorno de uma linha do banco de dados
 * quanto for utilizado o método toObject()
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
abstract class RowAbstract implements RowInterface, ServiceLocatorAwareInterface
{
    protected $_table = null;
    public $vars = array();
    protected $serviceLocator;

    public function getTableModelName()
    {
        return $this->_table;
    }
    /**
     * constroi um objeto do tipo linha
     * @param  string   $params
     * @return Ambigous <NULL, multitype:unknown >
     */
    public static function Factory(&$rows=null)
    {
        $extraArgs = func_get_args();
        /**
         * pega o nome da classe
         * pois não há linkagem atrada em php's < 3.5
         * @var [type]
         */
        $rowClass = get_called_class();
        $result = null;

        if (is_array($rows)) {

            $result = array();

            foreach ($rows as $elementId => $element) {
                $result[] = new $rowClass($element);
            }
        }

        return $result;
    }

    private static function treatField($fieldName)
    {
        $fieldName = explode('_',$fieldName);
        if (count($fieldName)> 1) {
            $result = "";
            foreach ($fieldName as $element) {
                $result.= $element;
            }

            return $result;
        }

        return reset($fieldName);
    }

    public function __construct($data=null)
    {
        $model =  new $this->_table;

        $schema = $model->getSchema();

        foreach ($schema as $elementId => $element) {

            $newColumnName = self::treatField($element['Field']);

            $this->vars[$newColumnName] = new \AckCore\Vars\Variable;
            $this->vars[$newColumnName]->setType($element['Type']);
            $this->vars[$newColumnName]->setColumnName($element['Field']);
            $this->vars[$newColumnName]->setTable($this->getTableModelName());
            if (!empty($data[$element['Field']])) {
                $this->vars[$newColumnName]->setBruteValue($data[$element['Field']]);
            }
        }
    }
    /**
     * cria chamadas dinâmicas
     * @param  [type] $method [description]
     * @param  array  $args   [description]
     * @return [type] [description]
     */
    public function __call($method, array $args)
    {
        /**
         * testa se não é um getter ou setter
         * @var [type]
         */
        $gsAttrName = strtolower(substr($method, 3));
        $gsActions = substr($method,0,3);

        if ($gsActions == "get") {
            return $this->getVar($gsAttrName);
        } elseif ($gsActions == "set") {
            $val = reset($args);

            return $this->setVar($gsAttrName,$val);
        }
        /**
         * testa se não é um método do tipo seekMyPhotos()
         */
        if ("seekMy" == substr($method, 0, 6)) {

            $result = null;
            //pega relações  1 => N
            if(!$this->getId()->getBruteVal())
                throw new \Exception("Impossível procurar por relações com o id vazio, verifique se o elemento não é nulo!");

            //trata de relacionamentos N => N
            if ("seekMyNN" == substr($method, 0, 8)) {
                //modelo de objetos a serem retornados
                $relatedModel = substr($method, 8);
                $namespace = ($args[4]) ? $args[4] : "\AckCore\Model\\";
                $relatedModel = $namespace.$relatedModel;
                //modelo de relacionamento
                $nnModel =& $args[0];
                //coluna de id do elemento atual
                $elementCol =& $args[1];
                //coluna de id do elemento relacionado
                $relatedCol =& $args[2];
                $result =  $this->nToNRelation($relatedModel,$nnModel,$elementCol,$relatedCol,$args[3]);
            } elseif ("seekMyFirst" == substr($method, 0, 11)) {
                $method = substr($method, 11);
                $result =  $this->oneToNRelation($method,true,$args[0],$args[1]);
                $result = reset($result);
            } else {
                //###################################################################################
                //################################# chamada seekMy###########################################
                //###################################################################################
                $method = substr($method, 6);
                $result =  $this->oneToNRelation($method,false,$args[0],$args[1]);
                //###################################################################################
                //################################# END chamada seekMy########################################
                //###################################################################################
            }

            return $result;
        }
        throw new \Exception("método desconhecido (".$method.") - verificar em ".get_class($this));
    }

    /**
     * implementação da automatizaç]ao para a busca de uma
     * coluna no esquema 1 => N
     * @param  [type] $method [description]
     * @return [type] [description]
     */
    protected function oneToNRelation($method, $first = false,$relatedCol,$nameSpace)
    {
        //seta a coluna default de relacionamentos
        $relatedCol = ($relatedCol) ? $relatedCol : "relacao_id";
        //seta o namespace default do objeto relacionado
        $nameSpace = ($nameSpace) ? $nameSpace : "\AckMultimidia\Model\\";
        $name = $method;
        $model = null;
        //se não conseguir um modelo de mesmo namespace
        //do atual pega o do ack

        $prefix = $this->getTablePrefix();
        $modelName = $prefix.$name;
        assert(0,"melhorar a busca da classe do módulo antes de pegar a do ack");

        if (file_exists($modelName)) {
            $model = new $modelName;
        } else {
            $modelName = $nameSpace.$name;
            $model = new $modelName;
        }

        $relatedTableModelName = $this->_table;
        $moduleId = \AckDb\ZF1\Utils::getModuleId($relatedTableModelName);
        if(empty($moduleId))
            throw new \Exception("id do módulo na relação não pode ser obtido");

        $where = array();
        if($model->hasColumn("modulo"))
            $where["modulo"] = $moduleId;

        if(!$model->hasColumn($relatedCol))
            throw new \Exception("tabela não tem a coluna $relatedCol necessária para esta funcionalidade");

        $where[$relatedCol] = $this->getId()->getBruteVal();

        $params = array();
        if($first)
            $params["limit"] = array("count" => 1, "offset"  => 0);

        $result  = $model->onlyNotDeleted()->toObject()->get($where,$params);
        //\AckCore\Utils::dg($result);
        return $result;
    }

    /**
     * faz a relaçao automática de um elemento N=>N
     * @param  [type] $relatedModel [description]
     * @param  [type] $nnModel      [description]
     * @param  [type] $elementCol   [description]
     * @param  [type] $relatedCol   [description]
     * @return [type] [description]
     */
    protected function nToNRelation($relatedModel,$nnModel,$elementCol,$relatedCol,$includedRelatedCols = array())
    {
        $model = new $nnModel();
        $where = array($elementCol=>$this->getId()->getBruteVal());

        $resultRelation = $model->get($where,array("order"=>"id ASC"));

        if(empty($resultRelation))

            return null;

        $result = null;

        $model = new $relatedModel();

        $counter = 0;
        if(!empty($resultRelation))
        foreach ($resultRelation as  $element) {
            $where = array("id"=>$element[$relatedCol]);
            $result[$counter] = $model->toObject()->onlyAvailable()->getOne($where);

            if (!empty($includedRelatedCols) && !empty($result[$counter] )) {

                foreach ($includedRelatedCols as $col) {

                    $variable = new \AckCore\Vars\Variable;
                    $variable->setBruteValue($element[$col]);
                    $result[$counter]->vars[$col]  = $variable;
                }
            }

            $counter++;
        }

        return $result;
    }

    public function setVar($column,$value)
    {
        if (!$this->vars[$column]) {
            if ($this->vars[$key.\AckCore\Language\Language::current()]) {
                $column  = $key.\AckCore\Language\Language::current();
            } else {
                throw new \Exception("Não foi possível encontrar a coluna: ($column) ");
            }
        }
        $this->vars[$column]->setBruteValue($value);

        return $this;
    }

    /**
     * salva o estado atual do objeto no banco de dados
     * @return \AckMvc\Controller\TableRowAutomatorAbstract
     */
    public function save($exceptions = array())
    {
        if(!($this->getId()->getBruteVal()))
            throw new \Exception("Objeto vazio não foi possível salvar");

        $model = $this->getTableInstance();
        $oldObject = $model->toObject()->getOne(array("id"=>$this->getId()->getBruteVal()));

        $set = array();
        foreach ($this->getVars() as $key=> $column) {

            if(in_array($column->getColumnName(), $exceptions))
                continue;

            $oldColumn = $oldObject->vars[$key];
            if($oldColumn->getBruteVal() != $column->getBruteVal())
                $set[$column->getColName()] = $column->getBruteVal();
        }

        if(empty($set))
            throw new \Exception("o array do update está vazio");

            $result = $modelTable = $this->getTableInstance()->update($set,array("id"=>$this->getId()->getBruteVal()));

        return $this;
    }

    /**
     * remove o objeto da compra
     * @return [type] [description]
     */
    public function delete()
    {
        if(!($this->getId()->getBruteVal()))
            throw new \Exception("Objeto vazio não foi possível deletar");

        $model = $this->getTableInstance();
        $result = $model->delete(array("id"=>$this->getId()->getBruteVal()));

        return $this;
    }

    public function getVar($key)
    {
        $currLanguage = \AckCore\Facade::getInstance()->getCurrentLanguage();

        if (isset($this->vars[$key])) {
            return $this->vars[$key];
        } elseif (isset($this->vars[$key.$currLanguage])) {
            return $this->vars[$key.$currLanguage];
        } else {
            $var =  new \AckCore\Vars\Variable;
            $var->setValue("Coluna não existente ( $key )");

            return $var;
        }
    }

    public function getCols()
    {
        return $this->vars;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function getTableInstance()
    {
        $modelName = $this->getTableModelName();
        $result = new $modelName();

        return $result;
    }

    /**
     * testa se uma linha tem conteúdo
     * em algum idioma (se ela tem o prefixo do idioma)
     * e se essa coluna está preenchida com algum dado
     * @param unknown $lang
     */
    public function hasLangContent($lang = "pt")
    {
        foreach ($this->getCols() as $column) {

            if ($lang == \AckCore\Utils\String::hasLangSuffix($column->getColName())) {

                $result = $column->getVal();
                if(!empty($result))

                    return true;
            }
        }

        return false;
    }

    /**
     * retorna um objeto de outro modelo referenciado por uma coluna
     * dessa linha
     * @param  unknown            $modelName    esse é o nome do modelo que a dependencia representa
     * @param  unknown            $colName      nome da coluna dessa linha que referencia
     * @param  string             $modelColName nome da coluna da tabela externa
     * @return unknown|NULL|mixed
     */
    public function getOuterRef($modelName,$colName,$modelColName = "id")
    {
        $model = new $modelName;
        $rowModelName = $model->getRowName();

        $colToMethod = str_replace("_", "", $colName);
        $getMethodName = "get".$colToMethod;

        $id = $this->$getMethodName()->getBruteVal();
        if(empty($id))

            return new $rowModelName;

        $where = array($modelColName=>$id);
        $result = $model->onlyNotDeleted()->toObject()->get($where);

        if (empty($result)) {
            return new $rowModelName;
        }

        $result = reset($result);

        return $result;
    }

    /**
     * testa se o objeto é do usuário
     * se nenhum u suário for passado o
     * teste será feito com o  usuário atualmente
     * logado
     * @param  [type]  $user [description]
     * @return boolean [description]
     */
    public function isFromUser($user = null,$columnName = null)
    {
        $user = ($user) ? $user : Auth_Usuario::getUserObjectStatic();
        $columnName = ($columnName) ? $columnName : "usuarioId";

        $columnName = "get".$columnName;

        if($this->$columnName()->getBruteVal() == $user->getId()->getBruteVal())

            return true;

        return false;
    }

    /**
     * retorna as metagas relacionadas com a linha
     * em questão
     * @return [type] [description]
     */
    public function getRelatedMetatags()
    {
        $modelName = $this->getTableModelName();

        $where = array("relacao_id"=>$this->getId()->getBruteVal(),
                        "modulo"=>$modelName::moduleId);

        $modelMeta = new \AckCore\Model\Metatags;
        $result = $modelMeta->toObject()->get($where);
        $result = end($result);
        if (empty($result)) {
            $result = new \AckCore\Model\Metatag;
            //trigger_error("não encontrou metatag criada e retournou uma vazia de exemplo", E_USER_NOTICE );
        }

        return $result;
    }

    public function getTablePrefix()
    {
        $prefix = $this->_table;
        $prefix = explode("\\",$prefix);
        $classKey = (count($prefix) -1);
        unset($prefix[$classKey]);

        //remonta
        $prefix = implode("\\", $prefix);
        $prefix.="\\";

        return $prefix;
    }

    /**
     * testa se o objeto passado tem o  mesmo id deste
     * @param  SystemDbRowAbstract $row [description]
     * @return [type]              [description]
     */
    public function sameId(\AckDb\ZF1\RowAbstract &$row)
    {
        if($row->getId()->getBruteVal() == $this->getId()->getBruteVal()) return true;

        return false;
    }

//###################################################################################
//################################# automatizações de multimídia###########################################
//###################################################################################
    public function getMyPhotos()
    {
        if(!$this->getId()->getBruteVal()) return array();

        $photos = $this->seekMyPhotos("relacao_id","\AckMultimidia\Model\\");

        $result = array();
       foreach ($photos as $photo) {
            $result[$photo->getId()->getBruteVal()] = $photo;
       }
       asort($result);

       return $result;
    }
    /**
     * retorna a primeira foto disponível a um elemento
     * @return [type] [description]
     */
    public function getMyFirstPhoto()
    {
        $photos = $this->getMyPhotos();

        if(empty($photos)) return new \AckMultimidia\Model\Photo;

        return reset($photos);
    }
    /**
     * retorna a primeira foto disponível a um elemento
     * @return [type] [description]
     */
    public function getMyLastPhoto()
    {
        $photos = $this->getMyPhotos();
        if(empty($photos)) return new \AckMultimidia\Model\Photo;

        return end($photos);
    }
    /**
     * retorna a capa ( não implmentado orretamente )
     * @return [type] [description]
     */
    public function getCover()
    {
        return $this->getMyLastPhoto();
        throw new \Exception("revisar esta função");
        $modelPhotos = new \AckMultimidia\Model\Photos;
        $photos = $modelPhotos->toObject()->onlyAvailable()->get(array("cover"=>1,
            "relacao_id"=>$this->getId()->getBruteVal(),
            "modulo"=>\AckClients\Model\Clients::moduleId));
        if(empty($photos))

            return new \AckMultimidia\Model\Photo;
        return reset($photos);
    }

    public function getMyVideos()
    {
        if(!$this->getId()->getBruteVal()) return array();

        return $this->seekMyVideos(null,"\AckMultimidia\Model\\");
    }
//###################################################################################
//################################# END automatizações de multimídia########################################
//###################################################################################

    //========================= chamadas de relacionamentos  =========================

    public function isChildOf(\AckDb\ZF1\RowAbstract $object,$hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys",$modelColumn = "master_id",$relatedColumn = "slave_id")
    {
        $modelNN = new $hierarchyObjectName;
        //testa se as colunas existem
        if(!$modelNN->hasColumn($modelColumn))
            throw new \Exception("coluna: $modelColumn  não exite na tabela ".$modelNN->getTableName());
        if(!$modelNN->hasColumn($relatedColumn))
            throw new \Exception("coluna: $relatedColumn  não exite na tabela ".$modelNN->getTableName());

        $where = array($relatedColumn =>$this->getId()->getBruteVal(),$modelColumn =>$object->getId()->getBruteVal());

        $result = $modelNN->get($where,array("count"=>array("offset"=>0,"total"=>1)));

        if(!empty($result))

            return true;
        return false;
    }
    //======================= END chamadas de relacionamentos  =======================

     //========================= getters and setters =========================

    /**
     * seta o localizador de servicos
     *
     * @param ServiceLocatorInterface $serviceLocator Zend\ServiceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    public function getServiceLocator()
    {

        if (empty($this->serviceLocator)) {
            return Facade::getServiceManager();
        }

        return $this->serviceLocator;
    }

    //======================= END getters and setters =======================

}
