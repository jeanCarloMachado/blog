<?php
namespace AckUsers\InputFilter;
use Zend\InputFilter\InputFilter;
class AlterarSenha extends InputFilter
{
    public function __construct()
    {
        $fsCreate = new InputFilter();

        $fsCreate->add(array(
                'name' => 'old_password',
                'required' => true,
                'validators' => array(
                    array(
                     "name" => 'NotEmpty',
                     "options" => array("messages"  => array( 'isEmpty' => "A senha antiga não pode estar vazia")),
                    ),
                ),
        ));

        $fsCreate->add(array(
                'name' => 'password',
                'required' => true,
                'validators' => array(
                    array(
                     "name" => 'NotEmpty',
                     "options" => array("messages"  => array( 'isEmpty' => "A nova senha não pode estar vazia")),
                    ),
                ),
        ));

        $fsCreate->add(array(
                'name' => 'password_repeated',
                'required' => true,
                'validators' => array(
                    array(
                     "name" => 'NotEmpty',
                     "options" => array("messages"  => array( 'isEmpty' => "A confimação da nova senha não pode estar vazia")),
                    ),
                ),
        ));

        $this->add($fsCreate, 'alterarSenhaGrp');
    }
}
