<?php
/**
 * gerenciamento ContatosimplesController
 *
 * AckDefault - Cub
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckContact\Controller;
use AckMvc\Controller\AbstractTableRowController as Controller;
/**
 * gerenciamento ContatosimplesController
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class ContatosimplesController extends Controller
{
    protected $models = array('default'=>'\AckContact\Model\ContatosSimples');

    public function contatarAction()
    {
        $vars = array();

        $vars['contatoPrototype'] = $this->getServiceLocator()->get('ContatosSimples')->getRowPrototype();
        
        //seta o captchA
        $vars['contatoPrototype']->vars['captcha'] = clone $vars['contatoPrototype']->vars['email'];
        $vars['contatoPrototype']->vars['captcha']->setColumnName('captcha');


        $vars['contatoConfig'] = array('whitelist'=>array('email','conteudo', 'captcha'), 'definitions'=>array('names'=>array(
            '/^conteudo.*$/'=>array('HTMLElementType' => 'TextArea')
        )));
        
        $this->viewModel->setVariables($vars);

        return $this->viewModel;
    }


    protected function contatarAjax()
    {
        $data = $this->getServiceLocator()->get('DataManager')
            ->setData($this->ajax)
            ->notEmpty(array('recaptcha_challenge_field','recaptcha_response_field')) 
            ->extract()
            ->getData(); 

        $this->getServiceLocator()->get('Captcha')->loadCaptchaLibrary();
        $privatekey = "6Le2qu8SAAAAAI4FqBHEh6Z7lN5AXK5ut7kzrWzn";
        $resp = recaptcha_check_answer (  $privatekey,
                                          $_SERVER["REMOTE_ADDR"],
                                          $data["recaptcha_challenge_field"],
                                          $data["recaptcha_response_field"]);

        if (!$resp->is_valid) {
             
            $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(0, 'O reCAPTCHA não foi informado corretamente.'); 
            return $this->request;
        }

        try { 
            $this->getServiceLocator()->get('ContatosSimples')->create($data);
        } catch (\Exception $e) {
           $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(0, $e->getMessage()); 
            return $this->request;
        }
        
        $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(array('mensagem'=>'Contato enviado com sucesso!')); 
        return $this->request;
    }
}
