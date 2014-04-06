<?php
namespace Craft;

use Mockery as m;

class ReferenceTagParserTest extends DoxterBaseTest
{
	public function testEntryReferenceTagParsingById()
	{
		$source	= '{entry:123456789:id}';
		$expect	= '{entry:123456789:id}';
		$parsed	= doxter()->referenceTagParser->parse($source);

		$this->assertEquals($expect, $parsed);
	}

	public function testEntryReferenceTagParsingBySlug()
	{
		$source	= '{entry:section/slug:id}';
		$expect	= '{entry:section/slug:id}';
		$parsed	= doxter()->referenceTagParser->parse($source);

		$this->assertEquals($expect, $parsed);
	}

	public function testUserReferenceTagParsingById()
	{
		$source	= '{user:123456789:email}';
		$expect	= '{user:123456789:email}';
		$parsed	= doxter()->referenceTagParser->parse($source);

		$this->assertEquals($expect, $parsed);
	}

	public function testUserReferenceTagParsingByEmail()
	{
		$source	= '{user:user@domain.com:email}';
		$expect	= '{user:user@domain.com:email}';
		$parsed	= doxter()->referenceTagParser->parse($source);

		$this->assertEquals($expect, $parsed);
	}

	public function testUserReferenceTagParsingByUsername()
	{
		$source	= '{user:username:email}';
		$expect	= '{user:username:email}';
		$parsed	= doxter()->referenceTagParser->parse($source);

		$this->assertEquals($expect, $parsed);
	}

	public function testAssetReferenceTagParsingById()
	{
		$source	= '{asset:123456789:id}';
		$expect	= '{asset:123456789:id}';
		$parsed	= doxter()->referenceTagParser->parse($source);

		$this->assertEquals($expect, $parsed);
	}

	public function setUp()
	{
		parent::setUp();
		parent::reloadConfig();

		$criteria	= m::mock('Craft\ElementCriteriaModel');
		$criteria->shouldReceive('find')->withAnyArgs()->andReturn(false);

		$elements	= m::mock('Craft\ElementsService');
		$elements->shouldReceive('getIsInitialized')->andReturn(true);
		$elements->shouldReceive('getCriteria')->withAnyArgs()->andReturn($criteria);

		$this->setComponent(craft(), 'elements', $elements);
	}
}
