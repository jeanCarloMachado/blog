<?php
namespace AckUsers\InputFilter;
use Zend\InputFilter\InputFilter;
class Cadastro extends InputFilter
{
    public function __construct()
    {
        $fsCreate = new InputFilter();

        $fsCreate->add(array(
                'name' => 'nome',
                'required' => true,
                'validators' => array(
                    array(
                     "name" => 'NotEmpty',
                     "options" => array("messages"  => array( 'isEmpty' => "O nome não pode ser vazio")),
                    ),
                ),
        ));

        $fsCreate->add(array(
                'name' => 'email',
                'required' => true,
        ));

        $fsCreate->add(array(
                'name' => 'senha',
                'required' => true,
        ));

        $this->add($fsCreate, 'fsCreate');

    }
}
