<?php
namespace Craft;

/**
 * Class DoxterHelper
 *
 * @package Craft
 */
class DoxterHelper
{
	protected static $instance;

	public static function instance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function d($target, $depth=5)
	{
		\CVarDumper::dump($target, $depth, true);
	}

	public function dd($target, $depth=5)
	{
		$this->d($target, $depth);
		exit;
	}

	public function get($key, array $arr=array(), $def=null)
	{
		return array_key_exists($key, $arr) ? $arr[$key] : $def;
	}

	public function getDefaultSyntaxSnippet()
	{
		return '<pre><code data-language="{languageClass}" {sourceCode}</code></pre>';
	}
}

if (!function_exists('doxter'))
{
	function doxter()
	{
		return DoxterHelper::instance();
	}
}
