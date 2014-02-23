<?php
/**
 * conteúdos do controller de insitucional
 *
 * descrição detalhada
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckContent\Controller;
use AckContent\Model\Users,
AckMvc\Controller\TableRowAutomatorAbstract;
class InstitucionalController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckContent\Model\Institutionals");
    protected $title = "Institucional";
    protected $config = array(
         "global"=>array(
                     "visibleCol"=>"visivel",
                     "disableImageCover" => true,
                     "blacklist" => array(),
                     "elementsSettings" => array(
                                    "titulopt"=> array(),
                                    "ordem"=> array("orderSelector" => true,"columnSpacing"=>80)
                                ),
                 ),
         "editar"=>array(
                             "metatags"=>true,
                             "plugins"=>true,

                             "multiplasImagens"=>true,
                             "tamanhoCrop"=>"511 340",
                             "abaImagens"=>true,
                             "abaVideos"=>true,
                             "abaAnexos"=>true,
                         ),
         //"salvar"=>array("metatags"=>true),
         "index" => array(

                            "whitelist" => array(
                                                "id",
                                                "titulopt",
                                                "ordem",
                                                "visivel"
                                            ),
                            "filters_file" => "filters.phtml",
                            "addButtonTitle" => "Adicionar Institucional",
                            "rmButtonTitle" => "Excluir Institucionais",
                        ),
    );

    public function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar" || $this->params("action") == "incluir" ) {

            if (\AckAcl\PermissionTester::isAllowed("view","\AckContent\Model\InstitutionalCategorys")) {

                $modelInstitutionalCategorys = new \AckContent\Model\InstitutionalCategorys;
                $InstitutionalCategorys = $modelInstitutionalCategorys->toObject()->onlyAvailable()->get(array("id IN (?)" => array(1,4)));
                $selectInstitutionalCategorys = \AckCore\HtmlElements\Select::getInstance()->setName("categoria_id")->setTitle("Categoria")->setPermission('rw')->setValue(0);

                if($config["row"]->getCategoriaId()->getBruteVal())
                        $where = (array("id"=>$config["row"]->getCategoriaId()->getBruteVal()));

                //pega a linha relacionada (caso ela existir)
                $selectedRow = $modelInstitutionalCategorys->getOne($where);

                foreach ($InstitutionalCategorys as $row) {
                    $selected = ($selectedRow->getId()->getBruteVal() == $row->getId()->getBruteVal()) ? true : false;
                    $selectInstitutionalCategorys->setOption($row->getId()->getBruteVal(),$row->getTitulo()->getVal(),$selected);
                }
                $config["toRenderCOL2"][] =& $selectInstitutionalCategorys;
            }
        }
    }

    /**
     * funçao para ser sobreescrita pelo usuário
     */
    protected function beforeReturn(&$config=null)
    {
        if ($this->params("action") == "index" ) {
            if (class_exists("\AckContent\Controller\Categoriasinstitucional")) {
                //instancia o modelo de relação
                $modelInstitutionalCategorys = new \AckContent\Model\InstitutionalCategorys;
                $InstitutionalCategorys = $modelInstitutionalCategorys->toObject()->onlyAvailable()->get();
                $config["categorys"]=& $InstitutionalCategorys;
            }
        }
        if (!empty($config)) {
            \AckCore\Facade::getInstance()->setControllerConfig($config);
        }
    }
}
