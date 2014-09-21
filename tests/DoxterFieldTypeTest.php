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
	public function testGetNameReturnsExpected()
	{
		$this->assertEquals('Doxter Markdown', $this->subject->getName());
	}

	public function testDefineSettingsReturnsProperlyDefinedSettings()
	{
		$expected	= array('enableSoftTabs', 'tabSize', 'rows');
		$settings	= $this->subject->defineSettings();

		$this->assertEquals($expected, array_keys($settings));
	}

	public function testDefineContentReturnsProperlyDefinedColumn()
	{
		$expected	= array(AttributeType::String, 'column' => ColumnType::LongText);

		$this->assertEquals($expected, $this->subject->defineContentAttribute());
	}

	public function testGetInputHtmlReturnsRenderedString()
	{
		$this->config->shouldReceive('getLocalized')->with('siteUrl')->andReturn('http://selvinortiz.dev');
		$this->config->shouldReceive('get')->with('addTrailingSlashesToUrls')->andReturn(false);

		$this->assertTrue($this->subject->getInputHtml('doxterMarkdown', '*markdown*'));
	}

	public function testGetDoxterFieldJsReturnsStringWithInitializerCode()
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
