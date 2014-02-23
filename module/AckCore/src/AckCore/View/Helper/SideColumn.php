<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
use \AckCore\DataAbstraction\Service\InterpreterForm;
use AckCore\ServiceLocator\Traits\ServiceLocatorAware;
class SideColumn extends AbstractHelper
{
    use ServiceLocatorAware;

    public function __invoke($config)
    {
        unset($config["blacklist"]);
        $config["whitelist"] = (isset($config["colB"]["whitelist"]) && !empty($colB["colB"]["whitelist"])) ? $colB["colB"]["whitelist"] : array();
        $elements = $this->getServiceLocator()->get('InterpreterForm')
        ->setContext(InterpreterForm::COL2)
        ->setCustomConfig($config)->buildElementsFromRow($config["row"]);

        if(is_array($elements)) foreach($elements as $element) $element->render();
    }
}
