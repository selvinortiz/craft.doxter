<?php
namespace Craft;

use Mockery as m;

class DoxterVariableTest extends DoxterBaseTest
{
	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testGetName()
	{
		$this->assertEquals('Doxter', doxter()->variable->getName(true));
	}

	public function testGetVersion()
	{
		$this->assertTrue((bool) preg_match('/\d+.\d+(.\d+)?/', doxter()->variable->getVersion()));
	}

	public function testGetDeveloper()
	{
		$this->assertEquals('Selvin Ortiz', doxter()->variable->getDeveloper());
	}

	public function testGetCpUrl()
	{
		$this->assertEquals('/admin/doxter/', doxter()->variable->getCpUrl());
	}
}
