<?php
namespace Craft;

use Mockery as m;

class MarkdownParserTest extends DoxterBaseTest
{
	public function testCodeBlockParsing()
	{
		$source	= '```php'
				. "\n"
				. "echo 'Doxter (ro|su)cks!';\n"
				. '```';
		$expect	= '<pre><code data-language="php">echo \'Doxter (ro|su)cks!\';</code></pre>';
		
		$params	= array(
			'codeBlockSnippet'	=> '<pre><code data-language="{languageClass}">{sourceCode}</code></pre>'
		);

		$parsed	= doxter()->markdownParser->parse($source, $params);

		$this->assertEquals($expect, $parsed);
	}

	public function testIsValidString()
	{
		$this->assertTrue(doxter()->markdownParser->isValidString('stringy'));
		$this->assertFalse(doxter()->markdownParser->isValidString(''));
	}
}
