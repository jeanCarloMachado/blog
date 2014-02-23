<?php
namespace AckContent\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class CategoriasinstitucionalController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckContent\Model\InstitutionalCategorys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Categorias Insitucionais";
    protected $config = array (

        "global" => array(
            "showId" => true,

            "blacklist"=>array("id","nome","ordem","status","visivel"),
            "columnSpacing" => 400,
            "elementsSettings" => array(
                "nome"=>array("orderSelector"=>true,"columnSpacing"=>450),
                //"nome"=>array("permission"=>"+r")
            ),
              "disableADDREMOVE" => true,
        ),
        "index" => array(
            "addButtonTitle" => "Adicionar Categoria Institucional",
            "rmButtonTitle" => "Excluir Categorias Institucionais",

            "whitelist"=>array("id","fakeid","titulo","visivel"),
        )
    );

    /**
     * funçao para ser sobreescrita pelo usuário
     */
    protected function beforeReturn(&$config=null)
    {
        if ($this->params("action") == "editar" ) {
            if($config["row"]->getId()->getBruteVal() == 6) $config = array_merge($config, array ( "plugins"=>true,
                             "multiplasImagens"=>false,
                             "tamanhoCrop"=>"511 340",
                             "abaImagens"=>false,
                             "abaVideos"=>true,
                             "abaAnexos"=>false,));
        }
    }
}
