<?php
namespace AckDevel\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
use \AckCore\Event, AckCore\Facade;
class DashboardController extends TableRowAutomatorAbstract
{
     protected $models = array("default"=>"\AckCore\Model\Systems");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Dashboard de administração";

    // protected $config = array (

    //     "global" => array(
    //         "disableLoadMore"=>true,
    //         "disableAutoParentFull" => true,
    //         "disableSuperiorListMenu" => true,
    //         "disableLoadMore"=>true,
    //         "disableAutoParentFull" => true,
    //         "disableSuperiorListMenu" => true,
    //         "disableBackButtons"=>true,
    //         "disableTitlePluralizer" => true,
    //     ),
    // );

     protected $config = array(
        "global"=>array(
                "disableLoadMore"=>true,
                "disableAutoParentFull" => true,
                "disableSuperiorListMenu" => true,
                "disableBackButtons"=>true,
                "disableTitlePluralizer" => true,
            )
    );

    /**
     * mostra o banco de dados na tela
     * @return [type] [description]
     */
    public function phpinfoAction()
    {
        phpinfo();
        die;
    }

    /**
     * retorna o esquema do banco de dados
     * @return [type] [description]
     */
    public function databaseAction()
    {
        $file_name = Facade::getPublicPath()."/../docs/database/schema.pdf";
        \AckCore\Utils\File::forceDownload($file_name);
        die;
    }
}
