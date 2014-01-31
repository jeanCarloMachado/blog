<?php
namespace AckUsers\Auth;
class User extends Authenticator
{
        /**
        * coluna de login
        * @var string
        */
        protected $identityColumn = "email";
        /**
        * coluna de senha
        * @var string
        */
        protected $credentialColumn = "senha";
        /**
        * nome do arquivo da classe de usuario extendendo System_DB_Table
        * @var [type]
        */
        protected $userTableModel = "\AckUsers\Model\Users";

}
