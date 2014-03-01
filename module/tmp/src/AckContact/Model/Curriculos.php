<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract as Table;
class Curriculos extends Table
{
    protected $_name = "ack_curriculos";
    protected $_row = "\AckContact\Model\Curriculo";

    const moduleName = "curriculos";
    const moduleId = 40;

    protected $colsNicks = array(
        "area_pretendida" => "Área pretendida",
        "email" => "E-mail",
        "suas_habilidades" => "Suas Habilidades",
        "salario_aceitavel" => "Salário aceitável",
        "salario_pretendido" => "Salário pretendido",
        "observacoes" => "Observações",
        "endereco" => "Endereço",
        "numero" => "Número",
        "fone_movel" => "Telefone móvel",
        "fone_fixo" => "Telefone fixo",
        "filhos" => "Quantidade de filhos",
        "estado_civil" => "Estado civil",
        "data_nascimento" => "Data de nascimento",
        "rg" => "RG",
        "cpf" => "CPF",
        "tempo_permanencia" => "Tempo de permanência",
        "atualmente_empregado" => "Atualmente empregado",
        "funcao_pretendida" => "Função pretendida",
        "fakeid" => "Id",
        "telefone_fixo" => "Telefone Fixo",
        "telefone_celular" => "Telefone Celular",
        "area" => "Área",
        "funcao" => "Função",
        "tempo" => "Tempo empregado",
        "informatica" => "Informática",
    );

    /**
     * cria uma linha no banco de dados recebendo um
     * array com suas colunas
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set, array $params = null)
    {
        if (!empty($set["anexo"])) {
            $set["anexo"] = explode("|",$set["anexo"]);
            $set["anexo"] = reset($set["anexo"]);
        }

        return parent::create($set /*, array("createNotFoundColumns"=>true)*/);
    }
}
