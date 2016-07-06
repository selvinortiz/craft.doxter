<?php
namespace Craft;

use Mockery as m;

class DoxterVariableTest extends DoxterBase
{
    /**
     * @var DoxterVariable
     */
    protected $subject;

    /**
     * UNIT TESTS
     * ----------
     */
    public function testGetName()
    {
        $this->assertEquals('Doxter', $this->subject->getName(true));
    }

    public function testGetVersion()
    {
        $this->assertTrue((bool)preg_match('/\d+.\d+(.\d+)?/', $this->subject->getVersion()));
    }

    public function testGetDeveloper()
    {
        $this->assertEquals('Selvin Ortiz', $this->subject->getDeveloper());
    }

    public function setUp()
    {
        parent::setUp();

        $this->subject = new DoxterVariable;
    }
}
