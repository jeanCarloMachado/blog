<?php
namespace AckUsers\InputFilter;
use Zend\InputFilter\InputFilter;
class Login extends InputFilter
{
    public function __construct()
    {

        $fsCreate = new InputFilter();

        $fsCreate->add(array(
                'name' => 'email',
                'required' => true,
        ));

        $fsCreate->add(array(
                'name' => 'senha',
                'required' => true,
        ));

        $this->add($fsCreate, 'fsOne');
    }
}
