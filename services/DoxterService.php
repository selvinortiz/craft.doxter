<?php
namespace Craft;

/**
 * The service layer and global API into Doxter
 *
 * Class DoxterService
 *
 * @author Selvin Ortiz - http://selvinortiz.com
 * @package Craft
 */

class DoxterService extends BaseApplicationComponent
{
	/**
	 * Parses source markdown into valid html using various rules and parsers
	 *
	 * @param string $source The markdown source to parse
	 * @param array $options Passed in parameters via a template filter call
	 *
	 * @return \Twig_Markup The parsed content flagged as safe to output
	 */
	public function parse($source, array $options=array())
	{
		$codeBlockSnippet				= null;
		$addHeaderAnchors				= true;
		$addHeaderAnchorsTo				= array('h1', 'h2', 'h3');
		$parseReferenceTags				= true;
		$parseReferenceTagsRecursively	= true;

		$options = array_merge(craft()->plugins->getPlugin('doxter')->getSettings()->getAttributes(), $options);

		extract($options);

		// Parsing reference tags first so that we can parse markdown within them
		if ($parseReferenceTags)
		{
			$source = DoxterReferenceTagParser::instance()->parse($source, compact('parseReferenceTagsRecursively'));
		}

		$source	= \ParsedownExtra::instance()->text($source);
		$source	= DoxterCodeBlockParser::instance()->parse($source, compact('codeBlockSnippet'));

		if ($addHeaderAnchors)
		{
			$source = DoxterHeaderParser::instance()->parse($source, compact('addHeaderAnchorsTo'));
		}

		return TemplateHelper::getRaw($source);
	}

	/**
	 * Ensures that a valid list of parseable headers is returned
	 *
	 * @param string $headerString
	 *
	 * @return array
	 */
	public function getHeadersToParse($headerString='')
	{
		$allowedHeaders = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');

		$headers = ArrayHelper::filterEmptyStringsFromArray(ArrayHelper::stringToArray($headerString));

		if (count($headers))
		{
			foreach ($headers as $key => $header)
			{
				$header = strtolower($header);

				if (!in_array($header, $allowedHeaders))
				{
					unset($headers[$key]);
				}
			}
		}

		return $headers;
	}
}
