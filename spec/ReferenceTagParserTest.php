<?php
namespace Craft;

use Mockery as m;

class ReferenceTagParserTest extends DoxterBase
{
    /**
     * @var DoxterReferenceTagParser
     */
    protected $subject;

    public function testEntryReferenceTagParsingById()
    {
        $source = '{entry:123456789:id}';
        $expect = '{entry:123456789:id}';
        $parsed = $this->subject->parse($source);

        $this->assertEquals($expect, $parsed);
    }

    public function testEntryReferenceTagParsingBySlug()
    {
        $source = '{entry:section/slug:id}';
        $expect = '{entry:section/slug:id}';
        $parsed = $this->subject->parse($source);

        $this->assertEquals($expect, $parsed);
    }

    public function testUserReferenceTagParsingById()
    {
        $source = '{user:123456789:email}';
        $expect = '{user:123456789:email}';
        $parsed = $this->subject->parse($source);

        $this->assertEquals($expect, $parsed);
    }

    public function testUserReferenceTagParsingByEmail()
    {
        $source = '{user:user@domain.com:email}';
        $expect = '{user:user@domain.com:email}';
        $parsed = $this->subject->parse($source);

        $this->assertEquals($expect, $parsed);
    }

    public function testUserReferenceTagParsingByUsername()
    {
        $source = '{user:username:email}';
        $expect = '{user:username:email}';
        $parsed = $this->subject->parse($source);

        $this->assertEquals($expect, $parsed);
    }

    public function testAssetReferenceTagParsingById()
    {
        $source = '{asset:123456789:id}';
        $expect = '{asset:123456789:id}';
        $parsed = $this->subject->parse($source);

        $this->assertEquals($expect, $parsed);
    }

    public function setUp()
    {
        parent::setUp();

        $this->subject = new DoxterReferenceTagParser;
        $criteria      = m::mock('Craft\ElementCriteriaModel');
        $elements      = m::mock('Craft\ElementsService');

        $criteria->shouldReceive('first')->withAnyArgs()->andReturn(false);
        $elements->shouldReceive('getIsInitialized')->andReturn(true);
        $elements->shouldReceive('getCriteria')->withAnyArgs()->andReturn($criteria);

        $this->setComponent(craft(), 'elements', $elements);
    }
}
