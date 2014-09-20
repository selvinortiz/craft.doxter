<?php
namespace Craft;

use Mockery as m;

class HeaderTagParserTest extends DoxterBaseTest
{
	public function testParse()
	{
		$source	= '<h1>Hi,</h1><p>This is a short paragraph.</p>';
		$expect	= '<h1 id="hi">Hi, <a class="anchor" href="#hi" title="Hi,">#</a></h1><p>This is a short paragraph.</p>';

		$this->assertEquals($expect, doxter()->headerParser->parse($source));
	}
}
