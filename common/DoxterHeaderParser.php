<?php
namespace Craft;

/**
 * Class DoxterHeaderParser
 *
 * @package Craft
 */
class DoxterHeaderParser extends DoxterBaseParser
{
	protected static $instance;

	/**
	 * Parses headers and adds anchors to them if necessary
	 *
	 * @param string $source HTML source to search for headers within
	 * @param array $options Passed in parsing options
	 *
	 * @return string
	 */
	public function parse($source, array $options=array())
	{
		$addHeaderAnchorsTo = array('h1', 'h2', 'h3');

		extract($options);

		if (!is_array($addHeaderAnchorsTo))
		{
			$addHeaderAnchorsTo = doxter()->getHeadersToParse($addHeaderAnchorsTo);
		}

		$headers	= implode('|', array_map('trim', $addHeaderAnchorsTo));
		$pattern	= sprintf('/<(?<tag>%s)>(?<text>.*?)<\/(%s)>/i', $headers, $headers);
		$source		= preg_replace_callback($pattern, array($this, 'handleMatch'), $source);

		return $source;
	}

	/**
	 * Uses the matched headers to create an anchor for them
	 *
	 * @param array $matches
	 *
	 * @return string
	 */
	public function handleMatch(array $matches=array())
	{
		$tag	= $matches['tag'];
		$text	= $matches['text'];
		$slug	= ElementHelper::createSlug($text);
		$clean  = strip_tags($text);
		return "<{$tag} id=\"{$slug}\">{$text} <a class=\"anchor\" href=\"#{$slug}\" title=\"{$clean}\">#</a></{$tag}>";
	}
}
