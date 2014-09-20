<?php
namespace Craft;

use Mockery as m;

class DoxterPluginTest extends DoxterBaseTest
{
	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testCanInstantiate()
	{
		$plugin = new DoxterPlugin;

		$this->assertTrue($plugin instanceof DoxterPlugin);
	}

	public function testGetName()
	{
		$this->assertEquals('Doxter', $this->plugin->getName(true));
		$this->assertTrue(is_string($this->plugin->getName()));
	}

	public function testGetVersion()
	{
		$this->assertTrue((bool) preg_match('/\d+.\d+(.\d+)?/', $this->plugin->getVersion()));
	}

	public function testGetDeveloper()
	{
		$this->assertEquals('Selvin Ortiz', $this->plugin->getDeveloper());
	}

	public function testGetDeveloperUrl()
	{
		$this->assertEquals('http://twitter.com/selvinortiz', $this->plugin->getDeveloperUrl());
	}

	public function testGetSnippetJs()
	{
		$expect = 'new Doxter(\'codeBlockSnippet\', {"tabSize":4,"softTabs":false});';

		$this->assertEquals($expect, $this->plugin->getSnippetJs());
	}

	public function testDefineSettings()
	{
		$this->assertTrue(is_array($this->plugin->defineSettings()));
	}

	public function testGetSettings()
	{
		$this->assertTrue($this->plugin->getSettings() instanceof BaseModel);
	}

	public function testAddTwigExtension()
	{
		$this->assertTrue($this->plugin->addTwigExtension() instanceof DoxterTwigExtension);
	}

	public function testGetCpSettingsUrl()
	{
		$this->assertEquals('/admin/settings/plugins/doxter/', $this->plugin->getCpSettingsUrl());
	}

	/**
	 * ENVIRONMENT
	 * -----------
	 */
	public function setUp()
	{
		parent::setUp();
		parent::reloadConfig();
		
		$this->plugin = new DoxterPlugin;
	}
}
