<?php
namespace AckUsers\InputFilter;
use Zend\InputFilter\InputFilter;
class RecuperarSenha extends InputFilter
{
    public function __construct()
    {
        $fsCreate = new InputFilter();

        $this->add(array(
                'name' => 'email',
                'required' => true,
        ));

    }
}
