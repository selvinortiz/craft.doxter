<?php
namespace SelvinOrtiz\Doxter;

class MarkdownParser extends BaseParser
{
	protected $codeBlockSnippet;

	public function parse($source=null, array $params=array())
	{
		$codeBlockSnippet	= null;

		extract($params);
		
		$source = Di::getInstance()->parsedown->parse($source);

		if (empty($codeBlockSnippet))
		{
			return $source;
		}

		$this->codeBlockSnippet = $codeBlockSnippet;

		return $this->parseCodeBlocks($source);
	}

	protected function parseCodeBlocks($source=null)
	{
		if (!$this->isValidString($source) || stripos($source, '<pre>') === false) { return $source; }

		$pattern	= '/<pre>(.?)<code class\="([a-z\-\_]+)">(.*?)<\/code>(.?)<\/pre>/ism';
		$source		= preg_replace_callback($pattern, array($this, 'handleBlockMatch'), $source);

		return $source;
	}

	protected function handleBlockMatch(array $matches=array())
	{
		$lang	= str_replace('language-', '', $matches[2]);
		$code	= $matches[3];
		$source	= str_replace('{languageClass}', $lang, $this->codeBlockSnippet);
		$source	= str_replace('{sourceCode}', $code, $source);

		return $source;
	}
}
