<?php

namespace AckUsers\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use AckUsers\InputFilter\Login as LoginInputFilter;

class Perfil extends Form
{
    public function __construct()
    {
        parent::__construct();

        //$this->setInputFilter(new LoginInputFilter);

        $this->setName('login');
        $this->setAttribute('method', 'post');

        //Fieldset One
        $this->add(array(
                            'name' => 'usuario',
                            'type' => 'Zend\Form\Fieldset',
                            'options' => array(
                            'legend' => 'Seus dados',
                            ),

                            'elements' => array(

                            )
                        )
                    );

        //Submit button
        $this->add(
            array(
                'name' => 'salvar',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Salvar',
                ),
                'options' => array(
                    'primary' => true,
                ),
            )
        );
    }
}
