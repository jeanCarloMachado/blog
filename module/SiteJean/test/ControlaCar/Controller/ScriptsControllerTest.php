<?php
namespace SiteJeanTest\Controller;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use SiteJean\Model\Carros;
class ScriptsControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include_once __DIR__.'../../../../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testAddEntrpriseColumn()
    {
        $model = new Carros;
        $tables = $model->run('SHOW TABLES');

        foreach ($tables as $table) {

            if (preg_match('/^car.*/', reset($table))) {
                $name = reset($table);

                $model->setTableName($name);
                if (!$model->hasColumn('empresa_id')) {
                    $this->assertTrue(false);
                } else {
                    $this->assertTrue(true);
                }
            }
        }
    }
}
