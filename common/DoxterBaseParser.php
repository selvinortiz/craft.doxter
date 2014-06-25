<?php
namespace Craft;

/**
 * Class DoxterBaseParser
 *
 * @package Craft
 */
abstract class DoxterBaseParser
{
	protected static $instance;

	public static function instance()
	{
		if (static::$instance === null)
		{
			$name = get_called_class();

			static::$instance = new $name;
		}

		return static::$instance;
	}

	/**
	 * Whether the source string can be safely parsed
	 *
	 * @param string $source
	 *
	 * @return bool
	 */
	public function canBeSafelyParsed($source)
	{
		if (empty($source))
		{
			return false;
		}

		return (is_string($source) || is_callable(array($source, '__toString')));
	}
}
