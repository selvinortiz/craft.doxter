<?php
namespace Craft;

use Mockery as m;

class DoxterTwigExtensionTest extends DoxterBaseTest
{
	/**
	 * UNIT TESTS
	 * ----------
	 */

	public function testGetName()
	{
		$this->assertEquals('Doxter Extension', doxter()->extension->getName());
	}

	public function testGetFilters()
	{
		$this->assertArrayHasKey('doxter', doxter()->extension->getFilters());
	}

	public function testParse()
	{
		$source	= '_emphazis_';
		$expect	= '<p><em>emphazis</em></p>';

		$this->assertEquals($expect, doxter()->extension->doxter($source));
	}
}
