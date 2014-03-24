<?php
namespace Craft;

use Mockery as m;

class DoxterFieldTypeTest extends DoxterBaseTest
{
	protected $fieldtype;

	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testGetName()
	{
		$this->assertEquals('Doxter Markdown', doxter()->fieldtype->getName());
	}

	public function testGetInputHtml()
	{
		$this->assertTrue(doxter()->fieldtype->getInputHtml('doxterMarkdown', '*markdown*'));
	}

	public function testGetDoxterFieldJs()
	{
		$this->assertTrue(stripos(doxter()->fieldtype->getDoxterFieldJs('doxter'), 'new Doxter') !== false);
	}

	public function setUp()
	{
		parent::setUp();

		$env = array('useCompressedResource' => true);

		doxter()->config->shouldReceive('get')->with('doxterSettings')->andReturn($env);
		doxter()->config->shouldReceive('get')->with('devMode')->andReturn(false);
		doxter()->config->shouldReceive('get')->with('actionTrigger')->andReturn('action');
		doxter()->config->shouldReceive('get')->with('defaultTemplateExtensions')->andReturn(array('.html'));
		doxter()->config->shouldReceive('get')->with('indexTemplateFilenames')->andReturn(array('index'));
		doxter()->config->shouldReceive('get')->with('translationDebugOutput')->andReturn('');
		doxter()->config->shouldReceive('parseEnvironmentString')->andReturn('');

		$templates	= m::mock('Craft\TemplatesService[render]');

		$templates->shouldReceive('render')->andReturn(true);

		$this->setComponent(craft(), 'templates', $templates);

	}
}
