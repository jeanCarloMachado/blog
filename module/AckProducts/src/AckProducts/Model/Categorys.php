<?php
/**
 * representa uma  tabela de categorias
 * (ajustar a nonclatura para o plural correto)
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
namespace AckProducts\Model;
use AckDb\Model\TableHierarchy;
class Categorys extends TableHierarchy
{
    protected $_name = "ack_categorias";
    protected $_row = "\AckProducts\Model\Category";
    const moduleName = "categorias_produtos";
    const moduleId = 19;

    protected $colsNicks = array(
        "visivel"=>"Visível",
    );

    /**
     * retorna somente objetos que são somente pais (SOBREESCRITO PARA RETORNAR ALFABETICAMENTE)
     * @return [type] [description]
     */
    public function getOnlyParents($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        return $this->getOnlyParentsWithWhere(array(), array(), $hierarchyObjectName);
    }

    /**
     * retorna somente objetos que são somente pais (SOBREESCRITO PARA RETORNAR ALFABETICAMENTE)
     * @return [type] [description]
     */
    public function getOnlyParentsWithWhere(array $where,array $params = null,$hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        $params = (!empty($params)) ? $params : array("order"=>"nome ASC");

        $result =  $this->toObject()->onlyAvailable()->get($where, $params);

        $modelHierarchys = new $hierarchyObjectName;
        $hierarchys = $modelHierarchys->toObject()->onlyAvailable()->get($where);

        foreach ($result as $key => $element) {

            foreach ($hierarchys as $hierarchy) {
                if ($element->getId()->getBruteVal()==$hierarchy->getSlaveId()->getBruteVal()) {
                    unset($result[$key]);
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * retorna as categorias com prdotuso
     * (atualmente está sendo testado na hora de mostrar se a categoria tem produto, caso não  a mesma não é mostrada)
     * @return [type] [description]
     */
    public function getOnlyCategorysWithProducts()
    {
    }
    /**
     * pega os produtos relacionados com a categoria atual e com os filhos da mesma
     * @return [type] [description]
     */
    public function getProductsFromCategoryAndChilds()
    {
    }

    public function getRelatedCategorysIdsFromCategoryId($categoryId)
    {
        $allRelations = array();
        $categorysIds = array();

        $category = \AckProducts\Model\Categorys::getFromId($categoryId);

        if ($category) {

            $category->getCategoryRecursiveRelations($category->getId()->getBruteVal(),$allRelations);
            $categorysIds[$category->getId()->getBruteVal()] = $category->getId()->getBruteVal();
        }

        foreach ($allRelations as $element) {
            $categorysIds[$element->getMasterId()->getBruteVal()] = $element->getMasterId()->getBruteVal();
        }

        return $categorysIds;
    }
    /**
     * pega as categorias relacionadas com um id de produto
     * @param  [type] $productId [description]
     * @return [type] [description]
     */
    public function getRelatedCategorysIdsFromProduct($productId)
    {
        $relationsProducts = $this->getProductRelated($productId);

        $allRelations = array();
        $categorysIds = array();

        /**
         * forma um bucket de relações de categorias com todas
         * relações para cada categoria relacioanda com as recebidas em relations
         */
        foreach ($relationsProducts as $relationProduct) {

            $category = $relationProduct->getCategory();

            if ($category) {
                $category->getCategoryRecursiveRelations($category->getId()->getBruteVal(),$allRelations);
                $categorysIds[$category->getId()->getBruteVal()] = $category->getId()->getBruteVal();
            }
        }

        foreach ($allRelations as $element) {
            $categorysIds[$element->getMasterId()->getBruteVal()] = $element->getMasterId()->getBruteVal();
        }

        return $categorysIds;
    }

    public function getProductRelated($productId)
    {
        if(!($productId))
            throw new \Exception("É necessário passar um id de produtopara a função funcionar corretamente");

        $modelRelation = new \AckProducts\Model\ProductsCategorys;
        $relation = $modelRelation->toObject()->get(array("produtos_id"=>$productId));

        return $relation;
    }

    /**
     * retorna a categoria passada e mas todos os seus filhos
     * @param  [type] $categoryId [description]
     * @return [type] [description]
     */
    public function getCategoryAndChild($categoryId)
    {
        $result = array();

        $category = \AckProducts\Model\Categorys::getFromId($categoryId);
        if(empty($category))

            return null;

        $result[] = $category;

        $bucket = array();
        $category->getCategoryRecursiveRelations($category->getId()->getBruteVal(), $bucket , 0);

        foreach ($bucket as $relation) {

            $result[]  = \AckProducts\Model\Categorys::getFromId($relation->getSlaveId()->getBruteVal());
        }

        return $result;
    }
    public function mountCategorysTree($category,&$bucket = array())
    {
        $bucket[$category->getId()->getBruteVal()] =  array(
                                        "id" => $category->getId()->getBruteVal(),
                                        "url" => "/produtos/categorias/".$category->getId()->getBruteVal()."/id",
                                        "nome" => $category->getNome()->getBruteVal(),
                                        "totalProdutos" => 0,
                                        "filhos" => array(),
                                          );
        $childs = $category->getChilds();

        if (!empty($childs)) {

            foreach ($childs as $child) {

                $this->mountCategorysTree($child,$bucket[$category->getId()->getBruteVal()]["filhos"]);

            }
        }
    }
    /**
     * dá um refresh na árvore de categorias retornado pelo mountCategorysTree
     * com os dados do produto atual
     * @param  [type] $product produto atual
     * @param  [type] $bucket  árvore de categorias
     * @return [type] [description]
     */
    public function refreshCategorysTree(&$product,&$bucket)
    {
        $productsRelations = $product->seekMyProductsCategorys("produtos_id","\AckProducts\Model\\");

        foreach ($productsRelations as $productRelation) {

            $tmpBucket = array();
            //pega as relações de categoria deste produto
             $this->getCategoryRecursiveRelations($productRelation->getCategoriasId()->getBruteVal(),$tmpBucket);
             $this->recursiveMatch($bucket,$tmpBucket);
        }

    }
    /**
     * pega as relações de categorias relacionadas ao id de categorias passado
     * @param  [type]  $categoryId            [description]
     * @param  [type]  $bucket                [description]
     * @param  integer $categoryPassedIsSlave [description]
     * @return [type]  [description]
     */
    public function getCategoryRecursiveRelations($categoryId, &$bucket ,$categoryPassedIsSlave = 1)
    {
        $modelRelations = new \AckProducts\Model\CategorysHierarchys;
        //pega todos os que são masters

        $affectedCol = ($categoryPassedIsSlave) ? "slave_id" : "master_id" ;
        $affectedCallCol = ($categoryPassedIsSlave) ? "getmasterid" : "getslaveid";

        $where = array($affectedCol => $categoryId);
        $tmp = $modelRelations->toObject()->get($where);
        foreach ($tmp as $element) {
            $bucket[$element->getId()->getBruteVal()] = $element;
            $this->getCategoryRecursiveRelations($element->$affectedCallCol()->getBruteVal(),$bucket,$categoryPassedIsSlave);
        }
    }
    /**
     * atualiza o bucket tual com o array de match, se os relacionamentos
     * condizem incrementa a a coluna totalProdutos
     * @param [type] $realBucket arrvore de categorias
     * @param  [type]  arvore de categorias do produto atual
     * @param  integer $counter [description]
     * @return [type]  [description]
     */
    protected function recursiveMatch(&$realBucket,&$matchBucket,$counter=0)
    {
         //testa para cada nível pai
         foreach ($realBucket as $buketId => $bucket) {

             $lastTmpBucket = end($matchBucket);

             if(!$lastTmpBucket) return;
             //se o último bucket do produto é igual a um dos pais de bucket oficial
             //incrementa o total de produtos recursivamente
             $method = ($counter) ? "getSlaveId" : "getMasterId";

             if ($bucket["id"] == $lastTmpBucket->$method()->getBruteVal()) {

                 $realBucket[$buketId]["totalProdutos"]++;
                 array_pop($matchBucket);
                 if (!empty($bucket["filhos"])) {
                     $this->recursiveMatch($realBucket[$buketId]["filhos"],$matchBucket,++$counter);

                 }
             }
         }
    }
}
