<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract as Table;
class Contacts extends Table
{
    protected $meta = array(
        "humanizedIdentifier" => "email",
   );
    protected $colsNicks = array("remetente" => "Remetente
", "empresa" => "Empresa
", "email" => "E-mail
", "fone" => "Telefone
", "endereco" => "Endereço
", "bairro" => "Bairro
", "cidade" => "Cidade
", "estado" => "Estado
", "cep" => "CEP
", "sexo" => "Sexo
", "setor" => "Setor
", "mensagem" => "Mensagem
", "data" => "Data
", "lido" => "Lido
");
    
    
    
    
    
    protected $_name = "ack_contatos";
    protected $_row = "\AckContact\Model\Contact";

    const moduleName = "contatos";
    const moduleId = 15;

    /**
     * retorna o total de contatos ainda não lindos
     * @return [type] [description]
     */
    public static function newContactsNum()
    {
        $modelContacts = new \AckContact\Model\Contacts;
        $result = $modelContacts->count(array("lido"=>"0"));

        return $result;
    }
}











