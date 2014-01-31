<?php
namespace AckUsers\Emails;
use AckCore\Mail\EmailEncapsulatedAbstract;
class RecuperarSenha extends EmailEncapsulatedAbstract
{
    protected $subject = "Recuperação de senha.";

    public function defaultLayout()
    {
        ?>
            <div style="font-family:Verdana, Geneva, sans-serif; font-size:21px; color:#656666; padding:35px 0 0 50px;">Olá, você solicitou a troca de senha do seu usuário.</div>
            <div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#656666; padding:35px 50px 30px 50px; line-height:20px;">

            Nome: <?php echo $this->getUsuario(); ?></br>
            Nova senha: <?php echo $this->getNovaSenha(); ?></br>
            </br>
        <?php
    }
}
