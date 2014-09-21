<?php
namespace Craft;

use Mockery as m;

class DoxterServiceTest extends DoxterBase
{
	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testParseCanTransformTextAndReturnExpectedMarkdownWithLinkableHeaders()
	{
		$source	= '# Doxter'
				. "\n"
				. '**Doxter** is a markdown plugin designed to improve the way you write documentation.';

		$expect	= '<h1 id="doxter">Doxter <a class="anchor" href="#doxter" title="Doxter">#</a></h1>'
				. "\n"
				. '<p><strong>Doxter</strong> is a markdown plugin designed to improve the way you write documentation.</p>';

		$parsed	= doxter()->parse($source, array('addHeaderAnchors' => true, 'addHeaderAnchorsTo' => 'h1'));

		$this->assertTrue($parsed instanceof \Twig_Markup);
		$this->assertEquals($expect, (string) $parsed);
	}

	public function testParseCanTransformTextAndReturnExpectedMarkdownWithoutParsingHeaders()
	{
		$source	= '# Doxter'
				. "\n"
				. '**Doxter** is a markdown plugin designed to improve the way you write documentation.';

		$expect	= '<h1>Doxter</h1>'
				. "\n"
				. '<p><strong>Doxter</strong> is a markdown plugin designed to improve the way you write documentation.</p>';

		$parsed	= doxter()->parse($source, array('addHeaderAnchors' => false));

		$this->assertTrue($parsed instanceof \Twig_Markup);
		$this->assertEquals($expect, (string) $parsed);
	}

	public function testParseCanTransformTextAndReturnExpectedMarkdownWithParsedCodeBlocks()
	{
		$source	= '# Doxter'
				. "\n"
				. '```php'
				. "\n"
				. 'echo "I love doxter";'
				. "\n"
				. '```'
				. "\n"
			. '**Doxter** is a markdown plugin designed to improve the way you write documentation.';

		$expect	= '<h1>Doxter</h1>'
				. "\n"
				. '<pre><code data-language="language-php">echo "I love doxter";</code></pre>'
				. "\n"
				. '<p><strong>Doxter</strong> is a markdown plugin designed to improve the way you write documentation.</p>';

		$parsed	= doxter()->parse($source, array('addHeaderAnchors' => false));

		$this->assertTrue($parsed instanceof \Twig_Markup);
		$this->assertEquals($expect, (string) $parsed);
	}

	public function setUp()
	{
		parent::setUp();
	}
}
