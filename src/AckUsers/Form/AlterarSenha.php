<?php
namespace AckUsers\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use AckUsers\InputFilter\AlterarSenha as AlterarSenhaInputFilter;

class AlterarSenha extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setInputFilter(new AlterarSenhaInputFilter);

        $this->setName('alterarSenha');
        $this->setAttribute('method', 'post');

        //Fieldset One
        $this->add(array(
                            'name' => 'alterarSenhaGrp',
                            'type' => 'Zend\Form\Fieldset',
                            'options' => array(
                            'legend' => 'Digite abaixo uma nova senha de acesso',
                            ),

                            'elements' => array(
                                array(
                                    'spec' => array(
                                        'name' => 'old_password',
                                        'type' => 'Zend\Form\Element\Password',
                                        'attributes' => array(
                                           'placeholder' => 'Digite aqui sua antiga senha',
                                        ),
                                        'options' => array(
                                            'label' => 'Senha Antiga',
                                        ),
                                    ),
                                ),
                                /**
                                 * ###################################################################################
                                 * nova senha
                                 *###################################################################################
                                 * @author Jean Carlo Machado <j34nc4rl0@gmail.com>
                                 */

                                 array(
                                    'spec' => array(
                                        'name' => 'password',
                                        'type' => 'Zend\Form\Element\Password',
                                        'attributes' => array(
                                           'placeholder' => 'Digite aqui sua nova senha',
                                        ),
                                        'options' => array(
                                            'label' => 'Nova Senha',
                                        ),
                                    ),
                                ),
                                 /**
                                  * ###################################################################################
                                  * nova senha repetida
                                  *###################################################################################
                                  * @author Jean Carlo Machado <j34nc4rl0@gmail.com>
                                  */

                                 array(
                                    'spec' => array(
                                        'name' => 'password_repeated',
                                        'type' => 'Zend\Form\Element\Password',
                                        'attributes' => array(
                                           'placeholder' => 'Digite novamente sua nova senha',
                                        ),
                                        'options' => array(
                                            'label' => 'Confirmar Senha',
                                        ),
                                    ),
                                ),
                            )
                        )
                    );

<<<<<<< HEAD
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security',
        ));
=======
        // $this->add(array(
        //     'type' => 'Zend\Form\Element\Csrf',
        //     'name' => 'security',
        // ));
>>>>>>> ControlaCar-master

        //Plain button
        $this->add(array(
            'name' => 'usuario-perfil',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Cancelar',
            ),
        ));

        //Submit button
        $this->add(
            array(
                'name' => 'salvarSenha',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Salvar Senha',
                ),
                'options' => array(
                    'primary' => true,
                ),
            )
        );
    }
}
