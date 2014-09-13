<?php
namespace AckMvcTest\Controller;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
class AckMvcControllerTest extends AbstractHttpControllerTestCase
{
	public function setUp()
	{
		$this->setApplicationConfig(
			include_once __DIR__.'../../../../../../config/application.config.php'
		);
		parent::setUp();
	}

	public function testInit()
	{
		echo "Teste de exemplificação";
		$this->assertEquals(1,1);
	}
}
