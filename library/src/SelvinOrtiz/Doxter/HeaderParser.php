<?php
namespace SelvinOrtiz\Doxter;

/**
 * Doxter Header Parser
 *
 * @package SelvinOrtiz\Doxter
 */
class HeaderParser extends Parser
{
	/**
	 * Parses headers and adds anchors
	 *
	 * @param	string	$source
	 * @param	array	$params
	 *
	 * @return	string
	 */
	public function parse($source=null, array $params=array())
	{
		$addHeaderAnchorsTo = array('h1', 'h2', 'h3');

		extract($params);

		$levels		= $this->getHeaderExpression($addHeaderAnchorsTo);
		$pattern	= sprintf('/<(%s)>([^<>]+)<\/(%s)>/i', $levels, $levels);
		$source		= preg_replace_callback($pattern, array($this, 'handleMatch'), $source);

		return $source;
	}

	public function handleMatch(array $matches=array())
	{
		$level	= $matches[1];
		$text	= $matches[2];
		$slug	= $this->createSlug($text);

		return "<{$level} id=\"{$slug}\">{$text} <a class=\"anchor\" href=\"#{$slug}\" title=\"{$text}\">#</a></{$level}>";
	}

	protected function getHeaderExpression($headers)
	{
		if (!is_array($headers))
		{
			$headers = array_map('strtolower', array_map('trim', explode(', ', $headers)));
		}

		return implode('|', $headers);
	}

	protected function createSlug($title)
	{
		return \Craft\ElementHelper::createSlug($title);
	}
}
