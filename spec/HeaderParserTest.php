<?php
namespace Craft;

use Mockery as m;

class HeaderTagParserTest extends DoxterBase
{
    /**
     * @var DoxterHeaderParser
     */
    protected $subject;

    public function testParse()
    {
        $source = '<h1>Hi,</h1><p>This is a short paragraph.</p>';
        $expect = '<h1 id="hi">Hi, <a class="anchor" href="#hi" title="Hi,">#</a></h1><p>This is a short paragraph.</p>';

        $this->assertEquals($expect,
            $this->subject->parse($source, array('addHeaderAnchors' => true, 'addHeaderAnchorsTo' => 'h1')));
    }

    public function setUp()
    {
        $this->subject = new DoxterHeaderParser();
    }
}
