<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
class Highlight extends AbstractHelper
{
    public static function run(array $params)
    {
        if (isset($params['class'])) {

            $tmp = strtolower($params['class']);
            $className = "\AckCore\Model\\".ucfirst($tmp);
            $product = new $className ;
            $result = $product->getTree(array('destaque'=>1,'visivel'=>'1'),array('module'=>8));
        }

        return $result;
    }

    public function __invoke($row,$disableHighlight=null)
        {
            if($disableHighlight || empty($row->vars["destaque"]))

              return null;
            \AckCore\HtmlElements\Highlight::Factory($row->getDestaque())->render();
        }
}
