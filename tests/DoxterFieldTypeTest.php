<?php
namespace Craft;

use Mockery as m;

class DoxterFieldTypeTest extends DoxterBase
{
	/**
	 * @var DoxterFieldType
	 */
	protected $subject;

	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testGetName()
	{
		$this->assertEquals('Doxter Markdown', $this->subject->getName());
	}

	public function testGetInputHtml()
	{
		$this->config->shouldReceive('getLocalized')->with('siteUrl')->andReturn('http://selvinortiz.dev');
		$this->config->shouldReceive('get')->with('addTrailingSlashesToUrls')->andReturn(false);

		$this->assertTrue($this->subject->getInputHtml('doxterMarkdown', '*markdown*'));
	}

	public function testGetDoxterFieldJs()
	{
		$this->assertTrue(stripos($this->subject->getDoxterFieldJs('doxter'), 'new Craft.DoxterFieldType') !== false);
	}

	public function setUp()
	{
		parent::setUp();

		$this->subject	= new DoxterFieldType();

		$this->config->shouldReceive('get')->with('doxterSettings')->andReturn(null);
		$this->config->shouldReceive('get')->with('devMode')->andReturn(false);
		$this->config->shouldReceive('get')->with('actionTrigger')->andReturn('action');
		$this->config->shouldReceive('get')->with('defaultTemplateExtensions')->andReturn(array('.html'));
		$this->config->shouldReceive('get')->with('indexTemplateFilenames')->andReturn(array('index'));
		$this->config->shouldReceive('get')->with('translationDebugOutput')->andReturn('');
		$this->config->shouldReceive('parseEnvironmentString')->andReturn('');

		$templates	= m::mock('Craft\TemplatesService[render]');

		$templates->shouldReceive('render')->andReturn(true);
		$this->setComponent(craft(), 'templates', $templates);
	}
}
