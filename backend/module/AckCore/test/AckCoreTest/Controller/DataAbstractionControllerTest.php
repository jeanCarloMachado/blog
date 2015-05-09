<?php
namespace AckCoreTest\Controller;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
class DataAbstractionControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include_once __DIR__.'../../../../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testQueryAutomatorAlterRightParams()
    {
        $ajax = array("filtros"=>array("titulo"=>"teste"));

        $model =  new \AckProducts\Model\Products;
        \AckCore\DataAbstraction\Service\InterpreterSearch::getInstance()->setModelRelated($model)->alterQueryClausules($ajax,$where,$params);
        $result =  $model->toObject()->onlyNotDeleted()->get($where,$params);
    }
}
