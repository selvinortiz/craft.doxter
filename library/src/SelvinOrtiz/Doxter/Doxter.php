<?php
namespace SelvinOrtiz\Doxter;

use SelvinOrtiz\Zit\IZit;

class Doxter
{
	public function parse($source, array $params = array()) 
	{
		$codeBlockSnippet				= null;
		$addHeaderAnchors				= true;
		$addHeaderAnchorsTo				= array('h1', 'h2', 'h3');
		$parseReferenceTags				= true;
		$parseReferenceTagsRecursively	= true;
		
		extract($params);

		// By parsing reference tags first, we have a chance to parse md within them
		if ($parseReferenceTags)
		{
			$source = Di::getInstance()->referenceTagParser->parse($source, compact('parseReferenceTagsRecursively'));
		}

		$source = Di::getInstance()->markdownParser->parse($source, compact('codeBlockSnippet'));
		
		if ($addHeaderAnchors)
		{
			$source = Di::getInstance()->headerParser->parse($source, compact('addHeaderAnchorsTo'));
		}

		return $source;
	}
}
