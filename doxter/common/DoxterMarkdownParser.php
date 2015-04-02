<?php
namespace Craft;

/**
 * The markdown parser
 *
 * Class DoxterCodeBlockParser
 *
 * @package Craft
 */
class DoxterMarkdownParser extends DoxterBaseParser
{
	/**
	 * @var object
	 */
	protected static $instance;
	protected static $markdownHelper;

	public static function getMarkdownHelper()
	{
		if (!static::$markdownHelper)
		{
			static::$markdownHelper = new \ParsedownExtra();
		}

		return static::$markdownHelper;
	}

	/**
	 * @param string $source
	 * @param array $options
	 *
	 * @return string
	 */
	public function parse($source, array $options=array())
	{
		return static::getMarkdownHelper()->text($source);
	}
}
