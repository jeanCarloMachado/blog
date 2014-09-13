<?php
namespace AckUsers\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use AckUsers\InputFilter\Login as LoginInputFilter;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setInputFilter(new LoginInputFilter);

        $this->setName('login');
        $this->setAttribute('method', 'post');

        //Fieldset One
        $this->add(array(
                            'name' => 'fsOne',
                            'type' => 'Zend\Form\Fieldset',
                            'options' => array(
                            'legend' => 'Já possui cadastro? Preencha os campos e clique em entrar',
                            ),

                            'elements' => array(
                                //Text
                                array(
                                        'spec' => array(
                                            'name' => 'email',
                                            'type' => 'Zend\Form\Element\Text',
                                            'attributes' => array(
                                                'placeholder' => 'Digite aqui se e-mail de cadastro',
                                             ),
                                        'options' => array(
                                            'label' => 'E-mail',
                                        ),
                                     ),
                                ),
                                //Password
                                array(
                                    'spec' => array(
                                        'name' => 'senha',
                                        'type' => 'Zend\Form\Element\Password',
                                        'attributes' => array(
                                           'placeholder' => 'Digite aqui sua senha',
                                        ),
                                        'options' => array(
                                            'label' => 'Senha',
                                        ),
                                    ),
                                ),
                            )
                        )
                    );

        // $this->add(array(
        //     'type' => 'Zend\Form\Element\Csrf',
        //     'name' => 'security',
        // ));

          //Plain button
        $this->add(array(
            'name' => 'recuperarSenha',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Esqueci minha senha',
            ),
        ));

        //Submit button
        $this->add(
            array(
                'name' => 'login',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Entrar',
                ),
                'options' => array(
                    'primary' => true,
                ),
            )
        );

    }
}
