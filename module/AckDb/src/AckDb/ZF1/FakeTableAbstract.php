<?php
namespace AckDb\ZF1;
abstract class FakeTableAbstract extends TableAbstract
{
    protected $schema;
    protected $rows;

    public function getSchema()
    {
        return $this->schema;
    }

    protected function _get(array $where=null,$params=null,$columns=null)
    {
        if (!empty($where)) {
            if (array_key_exists("id",$where)) {
                foreach ($this->rows as $element) {
                    if($where["id"] == $element["id"])
                        $result =  array($element);
                    }
            } else {
                throw new \Exception("Funcionalidade não implementada");
            }
        } else {
            $result =  $this->rows;

        }

        return $result;
    }
}
