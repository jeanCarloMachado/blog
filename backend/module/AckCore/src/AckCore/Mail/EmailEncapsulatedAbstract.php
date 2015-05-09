<?php
/**
 * emails encapsulados em objetos
 * PHP version 5
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\Mail;
use \AckCore\Interfaces\Dependency\DependencyMgr;
use \AckCore\HtmlEncapsulated;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

/**
 * classe base de e-mails
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class EmailEncapsulatedAbstract extends HtmlEncapsulated implements DependencyMgr
{
    protected $dependencys;
    protected $simulate = false;
    protected $subject = "Email do Ack";
    public static $enableSmtpTransport = false;

    public static function getInstance()
    {
        $className = get_called_class();
        $instance = new $className;

        return $instance;
    }

    public function __construct()
    {
        $this->dependencys["sender"] = "contato@icub.com.br";
    }

    public function send()
    {
        $result = null;
        $content = $this->getContent();
        $headers = $this->getHeaders();
        $destinatary = $this->getDestinatary();
        $subject = $this->getSubject();
        $sender = $this->getSender();

        if (self::$enableSmtpTransport) {

            // make a header as html
            $html = new MimePart($content);
            $html->type = "text/html";
            $body = new MimeMessage();
            $body->setParts(array($html));

            $message = new Message();
            $message->addTo($destinatary)
                    ->addFrom($sender)
                    ->setSubject($subject)
                    ->setBody($body);
            $message->setEncoding("UTF-8");

            // Setup SMTP transport using LOGIN authentication
            $transport = new SmtpTransport();
            $options   = new SmtpOptions(array(
                'name' => 'localhost',
                'host' => 'smtp.gmail.com',
                'port'=> 587,
                'connection_class' => 'login',
                'connection_config' => array(
                    'username' => 'j34nc4rl0@gmail.com',
                    'password' => '7nt3ll7g3nc319',
                    'ssl'=> 'tls',
                ),
            ));
            $transport->setOptions($options);
            $result = $transport->send($message);

        } else {

            if (is_array($destinatary)) {
                foreach ($destinatary as $destinataryRow) {
                    $result = mail($destinataryRow, $subject,$content ,$headers);
                }
            } else {
                $result = mail($destinatary, $subject,$content, $headers);
            }
        }

        return $result;
    }

    public function render()
    {
        if($this->simulationEnabled())
        echo $this->getHeaders()."</br>";
        $this->headerLayout();
        $layout =  $this->getLayout();
        $this->$layout();
        $this->footerLayout();
    }

    protected function getContent()
    {
        //###################################################################################
        //################################# guarda o conteúdo em uma variaável ###########################################
        //###################################################################################
        ob_start(); // start buffer
        $this->render();
        $content = ob_get_contents(); // assign buffer contents to variable
        ob_end_clean(); // end buffer and remove buffer contents

        return $content;
        //###################################################################################
        //################################# END guarda o conteúdo em uma variaável ########################################
        //###################################################################################
    }

    public function getHeaders()
    {
        $quebra_linha = PHP_EOL;
        //Define o cabeçalho do e-mail
        $headers = "MIME-Version: 1.1".$quebra_linha;
        $headers .= "Content-type: text/html; charset=utf-8".$quebra_linha;
        $headers .= "From: ".$this->getSender().$quebra_linha;
        $headers .= "Return-Path: ".$this->getSender().$quebra_linha;
        $headers .= "Reply-To: ".$this->getSender().$quebra_linha;

        return $headers;
    }

    /**
     * cria chamadas dinâmicas
     * @param  [type] $method [description]
     * @param  array  $args   [description]
     * @return [type] [description]
     */
    public function __call($method, array $args)
    {
        /**
         * testa se não é um getter ou setter
         * @var [type]
         */
        $gsAttrName = strtolower(substr($method, 3));
        $gsActions = substr($method,0,3);

        if ($gsActions == "get") {
            return $this->getDependency($gsAttrName);
        } elseif ($gsActions == "set") {
            $val = reset($args);

            return $this->setDependency($val,$gsAttrName);
        }
        throw new \Exception("Método não encontrado em __call()", 1);
    }

    public function setDependency($dependency,$key)
    {
        $this->dependencys[$key] = $dependency;

        return $this;
    }

    public function getDependency($key)
    {
        if(empty($this->dependencys[$key]))
            if($this->simulationEnabled())	return $key;
            else throw new \Exception("Não foi possível encontrar o valor de: $key", 1);
        return $this->dependencys[$key];
    }

    public function enableSimulation()
    {
        $this->simulate = true;

        return $this;
    }

    public function disableSimulation()
    {
        $this->simulate = false;
    }

    public function simulationEnabled()
    {
        return $this->simulate;
    }

    public function headerLayout()
    {
        ?>
        <table width="100%" border="0" bgcolor="#F7F7F7">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td width="25%" >&nbsp;</td>
        <td align="center">

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>E-mail do Ack</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style type="text/css">td img {display: block;}</style>
            </head>

            <body bgcolor="#ffffff">
                    <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                            <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="189" height="1" alt="" style="display:block; border:none;" /></td>
                            <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="33"  height="1" alt="" style="display:block; border:none;" /></td>
                            <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="155" height="1" alt="" style="display:block; border:none;" /></td>
                            <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="34"  height="1" alt="" style="display:block; border:none;" /></td>
                            <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="189" height="1" alt="" style="display:block; border:none;" /></td>
                            <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1"   height="1" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" bgcolor="#F7F7F7" style="line-height:10px;">&nbsp;</td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="10" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" bgcolor="#F7F7F7">&nbsp;</td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="50" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td bgcolor="#F7F7F7">&nbsp;</td>
                        <td colspan="3"><img name="logo" src="<?php echo \AckCore\Facade::getEmailLogoPath() ?>" width="222" height="70" id="logo" alt="" style="display:block; border:none;" /></td>
                        <td bgcolor="#F7F7F7">&nbsp;</td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="45" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" bgcolor="#F7F7F7">&nbsp;</td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="49" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5"><img name="logo" src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/logo_r9_c1.jpg" width="600" height="5" id="logo2" alt="" style="display:block; border:none;" /></td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="5" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="left" valign="top" bgcolor="#F7F7F7">
        <?php
    }

    public function footerLayout()
    {
        ?>
          </td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="475" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" bgcolor="#F7F7F7">&nbsp;</td>
                        <td><a href="<?php echo \AckCore\Facade::getEnderecoSite(); ?>" target="_blank"><img name="logo_r7_c3_pt" src="<?php echo \AckCore\Facade::getEmailLogoPath() ?>" width="155" height="37" id="logo_r7_c3" alt="" style="display:block; border:none;" /></a></td>
                        <td colspan="2" bgcolor="#F7F7F7">&nbsp;</td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="37" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" bgcolor="#F7F7F7">&nbsp;</td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="27" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5"><img name="logo_r9_c1" src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/logo_r9_c1.jpg" width="600" height="6" id="logo_r9_c1" alt="" style="display:block; border:none;" /></td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="6" alt="" style="display:block; border:none;" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" valign="middle" bgcolor="#F7F7F7">
                            <div style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#666666; line-height:20px;">
                                <a href="<?php echo \AckCore\Facade::getEnderecoSite(); ?>" target="_blank" style="text-decoration:none;color:#666666;"><?php echo \AckCore\Facade::getEnderecoSite(); ?></a>
                            </div>
                        </td>
                        <td><img src="<?php echo \AckCore\Facade::getEnderecoSite(); ?>/ack-core/images/email/spacer.gif" width="1" height="62" alt="" style="display:block; border:none;" /></td>
                    </tr>
                </table>
            </body>
        </html>

        </td>
        <td width="25%">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
        <?php
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }
}
