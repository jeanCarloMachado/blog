<?php
namespace AckUsers\Emails;
use AckCore\Mail\EmailEncapsulatedAbstract;
class NovoUsuario extends EmailEncapsulatedAbstract
{
    protected $subject = "Novo usuário criado.";

    public function defaultLayout()
    {
        ?>
        <div style="font-family:Verdana, Geneva, sans-serif; font-size:21px; color:#656666; padding:35px 0 0 50px;">Olá, um novo usuário do Ack foi criado para seu e-mail.</div>
        <div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#656666; padding:35px 50px 30px 50px; line-height:20px;">

        E-mail: <?php echo $this->getDestinatary(); ?></br>
        Senha: <?php echo $this->getPassword(); ?></br>
        </br>
        </div>
        <?php
    }
}
