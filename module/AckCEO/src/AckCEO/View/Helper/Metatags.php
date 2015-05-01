<?php
namespace AckCEO\View\Helper;
use Zend\View\Helper\AbstractHelper;
use AckCEO\Model\Metatags as ModelMeta;
use AckCore\Stdlib\ServiceLocator\ServiceLocatorAware;

class Metatags extends AbstractHelper
{
    use ServiceLocatorAware;

    public function __invoke($row = null)
    {
        $this->run($row);
    }

    /**
     * caso receba a linha o sistema
     * processa a metatag relacionada àquele elemento
     */
    public function run($row = null)
    {
        $modelMeta = new ModelMeta;
        $meta = null;
        $metatagsModel = $this->getServiceLocator()->get('Metatags');


        if (!empty($row) && $row->getId()->getBruteVal()) {
             /** @varMetatagsh object */
            $where = array('class_name'=>$row->getTableModelName(),'related_id'=>$row->getId()->getBruteVal());
            $meta = $metatagsModel->toObject()->getOne($where);
        }


        /**
        * se depois de todas as tentativas
        * nenhuma metatag foi retornada, busca a default do sistema
         */
            $metaMain = $modelMeta->toObject()->get(array(), array("limit"=>array("count"=>1)));
            $metaMain = end($metaMain);

            if(empty($meta)) {
                $meta = $metaMain;
                unset($metaMain);
            } else {
		$title = $meta->getTitle();
                if(empty($title)) {

                    $meta->setTitle($metaMain->getTitle()->getBruteVal());

                } else if (isset($metaMain)) {
                
                    $meta->setTitle($metaMain->getTitle()->getBruteVal().' - '.$meta->getTitle()->getBruteVal());
                }
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
