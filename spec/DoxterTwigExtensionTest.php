<?php
namespace Craft;

use Mockery as m;

class DoxterTwigExtensionTest extends DoxterBase
{
    /**
     * @var DoxterTwigExtension
     */
    public $subject;

    /**
     * UNIT TESTS
     * ----------
     */
    public function testGetName()
    {
        $this->assertEquals('Doxter Extension', $this->subject->getName());
    }

    public function testGetFilters()
    {
        $this->assertArrayHasKey('doxter', $this->subject->getFilters());
    }

    public function testParse()
    {
        $source = '_emphasis_';
        $expect = '<p><em>emphasis</em></p>';

        $this->assertEquals($expect, $this->subject->doxter($source));
    }

    public function setUp()
    {
        parent::setUp();

        $this->subject = new DoxterTwigExtension();
    }
}
