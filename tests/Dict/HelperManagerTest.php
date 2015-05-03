<?php

use \Knot\Dict\HelperManager;
use \Knot\Dict\Helpers\HelperInterface;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HelperManagerTest extends PHPUnit_Framework_TestCase {
	
	public function testConstruct()
	{
		$helper = new \Knot\Dict\HelperManager();
		$this->assertAttributeNotEmpty('helperList', $helper);
	}

	public function testAddSimpleHelper()
	{
		$simpleHelper = new SimpleHelper();

		$helperManager = $this->getHelperManager();

		$helperManager->loadHelper($simpleHelper);

		$knotObj = ar();

		$this->assertEquals("simple result!", $knotObj->simpleFunction());
	}

	public function testAddCopyOfSimpleHelper()
	{
		$copyOfSimpleHelper = new CopyOfSimpleHelper();

		$helperManager = $this->getHelperManager();

		$helperManager->loadHelper($copyOfSimpleHelper);

		$this->assertEquals(false, $helperManager->isRoute("simpleOtherFunction"));
	}

	public function getHelperManager()
	{
		return HelperManager::getInstance();
	}
}


class SimpleHelper implements HelperInterface
{
	public function getName()
	{
		return "simplehelper";
	}

	public function addRoutes(HelperManager $helperManager)
	{
		$helperManager->addRoute("simpleFunction", function($knot, $arguments)
			{
				return "simple result!";
			});
	}
}

class CopyOfSimpleHelper extends SimpleHelper
{
	public function addRoutes(HelperManager $helperManager)
	{
		$helperManager->addRoute("simpleOtherFunction", function($knot, $arguments)
			{
				return "simple result!";
			});
	}
}