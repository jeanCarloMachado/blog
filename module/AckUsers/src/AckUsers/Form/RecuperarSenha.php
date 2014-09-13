<?php
namespace AckUsers\Form;
use Zend\Form\Form;
use Zend\Form\Element;
<<<<<<< HEAD
=======
use AckUsers\InputFilter\RecuperarSenha as RecuperarSenhaInputFilter;
>>>>>>> SiteJean-master
class RecuperarSenha extends Form
{
    public function __construct()
    {
        parent::__construct();

<<<<<<< HEAD
        $this->setName('recuperarSenha');
        $this->setAttribute('method', 'post');

        //Fieldset One
        $this->add(array(
                            'name' => 'fsOne',
                            'type' => 'Zend\Form\Fieldset',
                            'options' => array(
                            'legend' => "Recupere sua senha preenchendo o campo e-mail abaixo.",
                            ),

                            'elements' => array(
                                //Text
                                array(
                                        'spec' => array(
                                            'name' => 'text',
                                            'type' => 'Zend\Form\Element\Text',
                                            'attributes' => array(
                                                'placeholder' => 'Digite aqui seu e-mail de cadastro',
                                             ),
                                        'options' => array(
                                            'label' => 'E-mail',
                                        ),
                                     ),
                                ),
                            )
                        )
                    );

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security',
        ));
=======
        $this->setInputFilter(new RecuperarSenhaInputFilter);
        $this->setName('recuperarSenha');
        $this->setAttribute('method', 'post');

        $this->add(
                    array(
                        'name' => 'recuperarsenha',
                        'type' => 'Zend\Form\Fieldset',
                        'options' => array(
                        'legend' => "Recupere sua senha preenchendo o campo e-mail abaixo.",
                        ),

                    'elements' => array(
                        //Text
                        array(
                                'spec' => array(
                                    'name' => 'email',
                                    'type' => 'Zend\Form\Element\Text',
                                    'attributes' => array(
                                        'placeholder' => 'Digite aqui seu e-mail de cadastro',
                                     ),
                                    'options' => array(
                                        'label' => 'E-mail',
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
>>>>>>> SiteJean-master

          //Plain button
        $this->add(array(
            'name' => 'voltar',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Voltar',
            ),
        ));
<<<<<<< HEAD
=======

>>>>>>> SiteJean-master
        //Submit button
        $this->add(
            array(
                'name' => 'submitBtn',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Enviar solicitação',
                ),
                'options' => array(
                    'primary' => true,
                ),
            )
        );

    }
}
