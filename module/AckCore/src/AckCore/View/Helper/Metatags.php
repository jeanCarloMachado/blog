<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
use \AckCore\Model\Metatags as ModelMeta;

class Metatags extends AbstractHelper
{
    public function __invoke($row = null)
    {
        $this->run();
    }

    /**
     * caso receba a linha o sistema
     * processa a metatag relacionada àquele elemento
     */
    public function run($row = null)
    {
        $modelMeta = new ModelMeta;
        $meta = null;

        if (!empty($row)) {
            $modelName = $row->getTableModelName();
            $model = new $modelName();
            $moduleId = $model->getModuleId();
            //pega os dados das metatags
            $modelMeta = new ModelMeta;
            $meta = $modelMeta->toObject()->get(array("modulo"=>$moduleId,"relacao_id"=>$row->getId()->getBruteVal()),array("order"=>"ID DESC","limit"=>array("count"=>1)));

            if(!empty($meta))
            $meta = end($meta);
        }

        /**
        * se depois de todas as tentativas
        * nenhuma metatag foi retornada, busca a default do sistema
        */
            $metaMain = $modelMeta->toObject()->get(array('id'=> ModelMeta::DEFAULT_SYSTEM_META_ID),array("order"=>"ID DESC","limit"=>array("count"=>1)));
            $metaMain = end($metaMain);

            if(empty($meta))
                $meta =& $metaMain;
            else {
                if(!isset($meta->vars["title"]) || !$meta->getTitle()->getBruteVal())
                    $meta->setTitle($metaMain->getTitle()->getBruteVal());

                if(!$meta->getdescription()->getVal())
                    $meta->setDescription($metaMain->getdescription()->getBruteVal());

                if(!$meta->getkeywords()->getVal())
                    $meta->setkeywords($metaMain->getkeywords()->getBruteVal());

                if(!$meta->getauthor()->getVal())
                    $meta->setauthor($metaMain->getauthor()->getBruteVal());

                if(!$meta->getrobots()->getVal())
                    $meta->setrobots($metaMain->getrobots()->getBruteVal());

                if(!$meta->getrevisit()->getVal())
                    $meta->setrevisit($metaMain->getrevisit()->getBruteVal());
            }
        ?>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="format-detection" content="telephone=no">
            <title><?php echo $meta->getTitle()->getVal() ?></title>
            <meta name="description" content="<?php echo $meta->getdescription()->getVal() ?>" />
            <meta name="keywords" content="<?php echo $meta->getkeywords()->getVal() ?>" />
            <meta name="author" content="<?php echo $meta->getauthor()->getVal() ?>" />
            <meta name="robots" content="<?php echo $meta->getrobots()->getVal() ?>" />
            <meta name="revisit-after" content="<?php echo $meta->getrevisit()->getVal() ?> days" />
        <?php
    }
}
