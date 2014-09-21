<?php
namespace Craft;

use Mockery as m;

class DoxterPluginTest extends DoxterBase
{
	/**
	 * @var DoxterPlugin
	 */
	protected $subject;

	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testGetNameReturnsNameOrAliasAsExpected()
	{
		$this->subject->getSettings()->setAttribute('pluginAlias', 'Markdown');
		$this->assertEquals('Doxter', $this->subject->getName(true));
		$this->assertEquals('Markdown', $this->subject->getName());
	}

	public function testGetVersionReturnsProperlyFormattedString()
	{
		$this->assertTrue((bool) preg_match('/\d+.\d+(.\d+)?/', $this->subject->getVersion()));
	}

	public function testGetDeveloperReturnsUntranslatedNameAsDefined()
	{
		$this->assertEquals('Selvin Ortiz', $this->subject->getDeveloper());
	}

	public function testGetDeveloperUrlAsDefined()
	{
		$this->assertEquals('http://selvinortiz.com', $this->subject->getDeveloperUrl());
	}

	public function testGetCodeBlockSnippetReturnsCorrectSyntaxDefinition()
	{
		$expect	= '<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>';

		$this->assertEquals($expect, $this->subject->getCodeBlockSnippet());
	}

	public function testDefineSettingsReturnsProperlyDefinedSettings()
	{
		$expected	= array(
			'codeBlockSnippet',
			'addHeaderAnchors',
			'addHeaderAnchorsTo',
			'parseReferenceTags',
			'parseReferenceTagsRecursively',
			'enableCpTab',
			'pluginAlias',
		);

		$this->assertEquals($expected, array_keys($this->subject->defineSettings()));
	}

	public function testGetSettingsHtmlReturnsRenderTemplateResult()
	{
		$this->assertTrue($this->subject->getSettingsHtml());
	}

	public function testGetSettingsReturnsSettingsModelOrBaseModel()
	{
		$this->assertTrue($this->subject->getSettings() instanceof BaseModel);
	}

	public function testAddTwigExtensionReturnsCorrectTwigExtensionObject()
	{
		$this->assertTrue($this->subject->addTwigExtension() instanceof DoxterTwigExtension);
	}

	/**
	 * ENVIRONMENT
	 * -----------
	 */
	public function setUp()
	{
		parent::setUp();

		$this->subject = new DoxterPlugin;
	}
}
