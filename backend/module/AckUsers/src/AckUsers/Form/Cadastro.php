<?php
namespace AckUsers\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use AckUsers\InputFilter\Cadastro as CadastroInputFilter;
class Cadastro extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setInputFilter(new CadastroInputFilter);

        $this->setName('login');
        $this->setAttribute('method', 'post');

        $this->add(
                    array(
                        'name' => 'fsCreate',
                        'type' => 'Zend\Form\Fieldset',
                        'options' => array(
                        'legend' => 'Deseja se cadastrar? Preencha os campos abaixo para continuar',
                        ),
                        'elements' => array(
                             //Text
                            array(
                                    'spec' => array(
                                        'name' => 'nome',
                                        'type' => 'Zend\Form\Element\Text',
                                        'attributes' => array(
                                            'placeholder' => 'Digite aqui seu nome completo',
                                         ),
                                    'options' => array(
                                        'label' => 'Nome',
                                    ),
                                 ),
                            ),
                            //Text
                            array(
                                    'spec' => array(
                                        'name' => 'email',
                                        'type' => 'Zend\Form\Element\Text',
                                        'attributes' => array(
                                            'placeholder' => 'Digite aqui seu e-mail',
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

        //Submit button
        $this->add(
            array(
                'name' => 'create',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Cadastrar-me',
                ),
                'options' => array(
                    'primary' => true,
                ),
            )
        );
    }
}
