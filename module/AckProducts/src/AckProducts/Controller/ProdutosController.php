<?php
namespace AckProducts\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ProdutosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckProducts\Model\Products");
    protected $title = "Produto";
    protected $config = array
    (
        "global" => array(
            "elementsSettings" => array(
                            "descricao" => array("columnSpacing" => 450, "type"=>"TextEditor")
                        ),
            "permission"=>"+r",
            "blacklist" => array(),
            //"disableImageCover" => true,
        ),
        "editar"=> array("plugins"=>true,
                "multiplasImagens"=>true,
                "tamanhoCrop"=>"500 400",
                "abaImagens"=>true,
                "abaVideos"=>true,
                "abaAnexos"=>true),
        "index" => array(
            "columnSpacing" => 300,
            "whitelist" => array(
                    "id",
                    "titulopt",
                    "descricaopt",
                    "visivel"
                ),
            "blacklist" => array(),
            //"filters_file" => "filters.phtml",
        ),
        "carregarMais" => array(
            "order" => "id DESC"
        )
    );

    /**
     * edita o valor de uma tag de produto
     * @return [type] [description]
     */
    protected function editar_novaTagAjax()
    {
        $set["chave"] =  $this->ajax["chave"];
        $set["valor"] = $this->ajax["valor"];
        $where["id"] = $this->ajax["id"];

        $model = new \AckProducts\Model\Tags;
        $resultId = $model->update($set,$where);

        echo json_encode(array("status"=>1,"mensagem"=>"Tag salva com sucesso!"));
        exit(1);
    }
    /**
     * pega os dados das categorias pra mandar para a renderização
     * @param unknown $config
     */
    protected function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar") {
            //pega os filhos em potencial
            $config["categorys"] = \AckProducts\Model\Categorys::getAll(array('order'=>'nome ASC'));
        }
    }

    public function loadMoreOnQuery(&$where = null, array &$params = null, array &$config)
    {
        $model =  $this->getInstanceOfModel();
        \AckCore\DataAbstraction\Service\InterpreterSearch::getInstance()->setRelatedModel($model)->alterQueryClausules($this->ajax,$where,$params);

        return $model->toObject()->onlyNotDeleted()->get($where,$params);
    }
}
