<?php
namespace Craft;

/**
 * Class DoxterHeaderParser
 *
 * @package Craft
 */
class DoxterHeaderParser extends DoxterBaseParser
{
	/**
	 * Parses headers and adds anchors to them if necessary
	 *
	 * @param string $source HTML source to search for headers within
	 * @param array $params Passed in parsing options
	 *
	 * @return string
	 */
	public function parse($source, array $params=array())
	{
		$addHeaderAnchorsTo = array('h1', 'h2', 'h3');

		extract($params);

		if (is_string($addHeaderAnchorsTo))
		{
			$addHeaderAnchorsTo = ArrayHelper::stringToArray(str_replace('|', ',', $addHeaderAnchorsTo));
		}

		$headers	= implode('|', array_map('trim', $addHeaderAnchorsTo));	// h1|h2|h3
		$pattern	= sprintf('/<(%s)>([^<>]+)<\/(%s)>/i', $headers, $headers);
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
		$tag	= $matches[1];
		$text	= $matches[2];
		$slug	= ElementHelper::createSlug($text);

		return "<{$tag} id=\"{$slug}\">{$text} <a class=\"anchor\" href=\"#{$slug}\" title=\"{$text}\">#</a></{$tag}>";
	}
}
