<?php
namespace AckCoreTest\Controller;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
class AckCoreControllerTest extends AbstractHttpControllerTestCase
{
	public function setUp()
	{
		$this->setApplicationConfig(
			include_once __DIR__.'../../../../../../config/application.config.php'
		);
		parent::setUp();
	}

	public function testIndexActionCanBeAccessed()
	{
		$this->assertEquals(1,1);
		
	}
}