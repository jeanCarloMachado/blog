<?php
namespace AckUsers\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class GruposdeusuariosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckUsers\Model\Groups");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Grupo";
    protected $config = array (
        "global" => array(
            //"columnSpacing" => 230,
            "showId" => true,
            "blacklist"=>array("id","ordem","status","visivel"),
            "elementsSettings" => array("descricaopt"=>array("columnSpacing"=>500)),
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","nome","descricaopt","visivel")
        )
    );
    /**
     * deve ser sobreescrita pelo usuário
     */
    protected function beforeRun(&$config=null)
    {
        //tesa se o usuário é do grupo adminstrador senão este não pode acessar este local
        if(!\AckCore\Facade::getCurrentUser()->hasGroupPermission(\AckUsers\Model\Group::GROUP_ADMIN))
            throw new \Exception("Você não tem permissão de grupo administrador para acessar esta página.");
    }
    /**
    * pega os dados das categorias pra mandar para a renderização
    * @param unknown $config
    */
    protected function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar") {
        //###################################################################################
        //################################# busca os dados da relacao com Groups ###########################################
        //###################################################################################
            //testa se a classe relacionada existe
            if (class_exists("\AckUsers\Model\Groups")) {
                /**
                 * //função responsável por buscar os Groups em seu modelo de table mostráveis nessa sessão do ack
                 *e mandálos para a visão para serem processados em uma lista de checks
                 *
                 * opções comummente usadas são:
                 * ::getAll();
                 * ::getAllDifferentFrom();
                 */
                $config["Groups"] =  \AckUsers\Model\Groups::getAllDifferentFrom($config["row"]->getId()->getBruteVal());
            }
        //###################################################################################
        //################################# END busca os dados da relacao com Groups ########################################
        //###################################################################################
        //###################################################################################
        //################################# pega os modulos ###########################################
        //###################################################################################
                // //pega a listagem de todos os módulos
                // $modules = new \AckCore\Model\Modules();
                // $config["modules"] = $modules->toObject()->onlyNotDeleted()->get();
        //###################################################################################
        //################################# END pega os modulos ########################################
        //###################################################################################
        }
    }
    /**
    * executado depois de salvar os dados principais
    * @param resultado do salvamento principal $result
    */
    protected function afterMainSave(&$result)
    {
        //descrobre o id desta sessão
        $id = $this->ajax[$this->getDefaultPackageName()]["id"];

        if ($this->ajax["acao"] == "editar") {

        //###################################################################################
        //################################# * salva o relacionamento com Groups ###########################################
        //###################################################################################
            //testa se a classe relacionada existe
            if (class_exists("\AckUsers\Model\Groups")) {
                $modelRelation = new \AckUsers\Model\GroupsHierarchys;
                // primeiramente remove-se os elementos de relação existentes
                $modelRelation->delete(array("master_id"=>$id));

                //testa a real existẽncia do array de relacionamento
                if(!isset($this->ajax["Groups"]["Groups"]))
                    throw new Exception("Não encontrou os elementos que deveriam ser passados no array de relações ");

                //guarda em uma variável os elementos
                $elements  = $this->ajax["Groups"]["Groups"];

                //cria cada os relacionamentos marcados nos checks
                foreach($elements as $element)
                    $modelRelation->create(array("slave_id"=>$element,"master_id"=>$id));
            }
       //###################################################################################
        //################################# END 	 * @type {[type]} ########################################
        //###################################################################################
        }
    }

    // /**
    // * salva as permissões dos usuários do ack
    // */
    // public function salvarPermissoesAction()
    // {
    // 	if(empty($this->ajax["id"]))
    // 		throw new \Exception("O id do usuário não foi passado na chave id");

    // 	$model = new \AckUsers\Model\Permissions();
    // 	$result = $model->savePermissionsBlock($this->ajax);

    // 	$json = array();
    // 	$json['status'] = $result;
    // 	echo json_encode($json);
    // 	return $this->response;
    // }
}
