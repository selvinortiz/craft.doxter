<?php
namespace Craft;

use Mockery as m;

class DoxterServiceTest extends DoxterBaseTest
{
	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testParse()
	{
		$source	= '# Doxter'
				. "\n"
				. '**Doxter** is a markdown plugin designed to improve the way you write documentation.';

		$expect	= '<h1 id="doxter">Doxter <a class="anchor" href="#doxter" title="Doxter">#</a></h1>'
				. "\n"
				. '<p><strong>Doxter</strong> is a markdown plugin designed to improve the way you write documentation.</p>';

		$parsed	= doxter()->service->parse($source);

		$this->assertTrue($parsed instanceof \Twig_Markup);
		$this->assertEquals($expect, (string) $parsed);
	}

	public function testGetBoolFromLightSwitch()
	{
		$this->assertTrue(doxter()->service->getBoolFromLightSwitch('y'));
		$this->assertTrue(doxter()->service->getBoolFromLightSwitch('on'));
		$this->assertTrue(doxter()->service->getBoolFromLightSwitch('yes'));
		$this->assertFalse(doxter()->service->getBoolFromLightSwitch('no'));
		$this->assertFalse(doxter()->service->getBoolFromLightSwitch('true'));
	}

	public function testGetEnvOptions()
	{
		$envOptions = array(
			'useCompressedResources'	=> true,
		);

		// If no options are available
		doxter()->config->shouldReceive('get')->with('doxterSettings')->andReturn(null)->byDefault();
		$this->assertNull(doxter()->service->getEnvOption('useCompressedResources'));

		// If options are available
		doxter()->config->shouldReceive('get')->with('doxterSettings')->andReturn($envOptions);

		$this->assertTrue(doxter()->service->getEnvOption('useCompressedResources'));
		$this->assertEquals(null, doxter()->service->getEnvOption('baseDocumentPath'));
		$this->assertEquals('/base/path', doxter()->service->getEnvOption('baseDocumentPath', '/base/path'));
	}

	public function testSafeOutput()
	{
		$charset = 'UTF-8';
		$content = '<p>Flag as safe and do not escape html</p>';

		$this->assertTrue(doxter()->service->safeOutput($content, $charset) instanceof \Twig_Markup);
		$this->assertEquals($content, (string) doxter()->service->safeOutput($content, $charset));
	}
}
