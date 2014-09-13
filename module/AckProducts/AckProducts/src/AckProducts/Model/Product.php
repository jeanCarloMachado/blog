<?php
namespace AckProducts\Model;
use AckDb\Model\RowHierarchy;
class Product extends RowHierarchy
{
    const TOTAL_SIMILAR_PRODUCTS = 3;
    protected $_table = "\AckProducts\Model\Products";
    protected static $cache;

    /**
     * retorna os produtos similares
     * @return [type] [description]
     */
    public function getMySimilarProducts()
    {
        $totalGot = 0;
        $result = array();
        //###################################################################################
        //################################# pega produtos da mesma marca ###########################################
        //###################################################################################
        $marcas = $this->getMyMarcas();
        if (!empty($marcas)) {
            foreach ($marcas as $marca) {
                $products = $marca->getProductsRelated(self::TOTAL_SIMILAR_PRODUCTS,array($this->getId()->getBruteVal()));
                if (!empty($products)) {
                  $result = array_merge($result,$products);
                }
            }
            $totalGot = count($result);
        }
        //###################################################################################
        //################################# END pega produtos da mesma marca ########################################
        //###################################################################################
        //###################################################################################
        //################################# fall back pega os 3 próximos produtos ###########################################
        //###################################################################################
        if ($totalGot < self::TOTAL_SIMILAR_PRODUCTS) {
            $modelName = $this->getTableModelName();
            $model = new $modelName;
            $tmpResult = $model->toObject()->onlyAvailable()->get(array("id > "=>$this->getId()->getBruteVal()),array("limit"=>array("count"=>(self::TOTAL_SIMILAR_PRODUCTS - $totalGot))));
            $result = array_merge($result,$tmpResult);
        }
        //###################################################################################
        //################################# END fall back pega os 3 próximos produtos ########################################
        //###################################################################################
        return $result;
    }

    /**
     * retorna verdadeiro se a categoria passada está relacionada
     * com o produto em questão não importando o nível de hierarquia
     * @param  \AckDb\ZF1\RowAbstract $category [description]
     * @return boolean                [description]
     */
    public function isRelatedCategoryOrParent(\AckDb\ZF1\RowAbstract $category)
    {
        $model = new \AckProducts\Model\ProductsCategorys();

        $resultRelation  = $model->get(array(
            "produtos_id"=>$this->getId()->getBruteVal(),
            "categorias_id" => $category->getId()->getBruteVal())
        );

        if(!empty($resultRelation))

            return true;
        return false;
    }

    /**
     * retorna os componentes com a relação juntamente.
     * @return [type] [description]
     */
    public function findMyComponentsAndRelation()
    {
        $modelRelation = new \AckProducts\Model\ProductsComponents;
        $relations = $modelRelation->toObject()->onlyNotDeleted()->get(array("produto_id"=>$this->getId()->getBruteVal()));
        $result = array();

        foreach ($relations as $relation) {
            $obj = \AckProducts\Model\Products::getFromId($relation->getcomponenteid()->getBruteVal());
            $obj->vars["relation"] = $relation;
            $result[] = $obj;
        }

        return $result;
    }

     /**
     * retorna os componentes com a relação juntamente.
     * @return [type] [description]
     */
    public function findMyModelosAndRelation()
    {
        $modelRelation = new \ElefranAck\Model\ProductsModelos;
        $relations = $modelRelation->toObject()->onlyNotDeleted()->get(array("produto_id"=>$this->getId()->getBruteVal()));
        $result = array();

        foreach ($relations as $relation) {
            $obj = \ElefranAck\Model\Modelos::getFromId($relation->getModeloId()->getBruteVal());
            $obj->vars["relation"] = $relation;
            $result[] = $obj;
        }

        return $result;
    }

    /**
     * retorna os produtos que são componentes deste produto
     * @return [type] [description]
     */
    public function findMyComponents()
    {
        return $this->seekMyNNProducts("\ElefranAck\Model\ProductsComponents","produto_id","componente_id",null,"\AckProducts\Model\\");
    }

    /**
     * retorna os objetos de modelos a qual um produto está relacionado
     * @return [type] [description]
     */
    public function getMyModelos()
    {
        return $this->seekMyNNModelos("\ElefranAck\Model\ProductsModelos","produto_id","modelo_id",null,"\ElefranAck\Model\\");
    }

    public function getMyMarcas()
    {
        $modelos = $this->getMyModelos();
        if(empty($modelos)) return array();

        $marcas = array();
        foreach ($modelos as $modelo) {
            $veiculo = $modelo->getMyVeiculo();
            if($veiculo->getMarcaId()->getBruteVal())
                $result = \ElefranAck\Model\Marcas::getFromId($veiculo->getMarcaId()->getBruteVal());

                if(!empty($result))
                    $marcas[] =  $result;
        }

        return $marcas;
    }

    public function getMyVeiculos()
    {
        $modelos = $this->getMyModelos();
        if(empty($modelos))

            return array();

        $veiculos = array();
        foreach ($modelos as $modelo) {
            if($modelo->getVeiculoId()->getBruteVal())
                $result = \ElefranAck\Model\Veiculos::getFromId($modelo->getVeiculoId()->getBruteVal());

                if(!empty($result))
                    $veiculos[] =  $result;
        }

        return $veiculos;
    }

    //###################################################################################
    //################################# específico da elefran ###########################################
    //###################################################################################

    public function getMarcasAlternativas()
    {
        if(isset(self::$cache[__FUNCTION__.$this->getId()->getBruteVal()])) return self::$cache[__FUNCTION__.$this->getId()->getBruteVal()];

        $marcas = $this->seekMyNNMarcaAlternativas("\ElefranAck\Model\ProdutosMarcasAlternativas","produto_id","marca_id",null,"\ElefranAck\Model\\");

        self::$cache[__FUNCTION__.$this->getId()->getBruteVal()] = $marcas;

        return $marcas;
    }
    //###################################################################################
    //################################# END específico da elefran ########################################
    //###################################################################################
}
