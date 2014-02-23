<?php
namespace AckCore\HtmlElements\Specific;
use AckCore\HtmlElements\Select;
class SelectPersonType extends Select
{
    public static function getInstance()
    {
        $instance = parent::getInstance();
        $instance->setName("tipo_id")->setTitle("Tipo de pessoa");

        return $instance;
    }

    protected $options = array("Física"=>1,"Jurídica"=>2);

}
