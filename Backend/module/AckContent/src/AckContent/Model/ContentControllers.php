<?php
namespace AckContent\Model;
use AckDb\ZF1\TableAbstract;
class ContentControllers extends TableAbstract
{
    protected $_name = "ack_conteudos_controllers";
    protected $_row = "\AckContent\Model\ContentController";

    public static function getContentsFromControllerStr($controller,$action = null)
    {
        $model = new ContentControllers;

        if (empty($controller)) {
            throw new \Exception("a string do controlador está vazia");
        }

        $where = array("controller"=>$controller);

        $resultController = $model->toObject()->onlyAvailable()->get($where);

        if(empty($resultController))

            return false;

        $contentsIds = array();
        foreach ($resultController as $element) {
            $contentsIds[]  = $element->getConteudoId()->getBruteVal();
        }

        if (empty($contentsIds)) {
            return false;
        }

        $modelContents = new \AckContent\Model\Contents;
        $sql = "SELECT * FROM ".$modelContents->getTableName()." WHERE ( 1=0 ";

        foreach ($contentsIds as $element) {
            if(!$element)
                continue;
            $sql.= " OR id = $element";
        }

        $sql.= ") AND status = 1 AND visivel = 1";

        $result = $modelContents->run($sql);
        $result = \AckContent\Model\Content::Factory($result);
        if(!empty($action))
            foreach ($result as $key => $element) {
                $actions = unserialize($element->getAcoes()->getBruteVal());
                if(!in_array($action, $actions))
                    unset($result[$key]);
            }

        return $result;
    }
}
