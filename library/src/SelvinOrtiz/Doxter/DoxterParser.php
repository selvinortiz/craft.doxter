<?php
namespace SelvinOrtiz\Doxter;

class DoxterParser extends Parser
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
			$source = doxter()->referenceTagParser->parse($source, compact('parseReferenceTagsRecursively'));
		}

		$source = doxter()->markdownParser->parse($source, compact('codeBlockSnippet'));

		if ($addHeaderAnchors)
		{
			$source = doxter()->headerParser->parse($source, compact('addHeaderAnchorsTo'));
		}

		return $source;
	}
}
