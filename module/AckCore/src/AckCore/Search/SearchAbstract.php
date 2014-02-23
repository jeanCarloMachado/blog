<?php
namespace AckCore\Search;
use AckCore\ExtendedObject;
class SearchAbstract extends ExtendedObject
{
    protected $query = null;
    protected $toObject = null;
    protected $result = null;
    protected $itemInicial = 0;
    protected $count = 10;
    protected $totalCount = 0;
    protected $model = "\AckProducts\Model\Products";
    protected $modelInstance = null;
    protected $queryParams = null;
    protected $returnNull = false;
    protected $enableCount = 0;

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    public function makeCount()
    {
        $this->enableCount = 1;

        return $this;
    }

    public function buildMainQuery()
    {
        return $this;
    }

    public function run()
    {
        if($this->getReturnNull())

            return $this;

        $instance = $this->getModelInstance();

        if ($this->enableCount) {
            $countQuery = substr($this->query, 8);
            $countQuery = "select count(*)  ".$countQuery;
            $this->totalCount = $instance->run($countQuery);
            $this->totalCount = $this->totalCount[0]["count(*)"];
        }

        //adiciona count e limit
        $this->query.= " LIMIT ".$this->getItemInicial().",".$this->getCount();

        $query = $this->query;

        $this->result = $instance->run($query);

        if ($this->toObject()) {
            $row = $instance->getRowName();
            $this->result = $row::Factory($this->result);
        }

        return $this;
    }

    public function formatResult()
    {
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function getToObject()
    {
        return $this->toObject;
    }

    public function toObject()
    {
        $this->toObject = true;

        return $this;
    }

    public function setToObject($toObject)
    {
        $this->toObject = $toObject;

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    public function getItemInicial()
    {
        return $this->itemInicial;
    }

    public function setItemInicial($itemInicial)
    {
        $this->itemInicial = $itemInicial;

        return $this;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    public function getModelInstance()
    {
        if (!$this->modelInstance) {

            $modelName = $this->getModel();
            $this->setModelInstance(new $modelName());
        }

        return $this->modelInstance;
    }

    public function setModelInstance($modelInstance)
    {
        $this->modelInstance = $modelInstance;

        return $this;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function setQueryParams($queryParams)
    {
        $this->queryParams = $queryParams;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getReturnNull()
    {
        return $this->returnNull;
    }

    public function setReturnNull($returnNull)
    {
        $this->returnNull = $returnNull;

        return $this;
    }

}
