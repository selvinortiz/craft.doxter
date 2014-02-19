<?php
namespace SelvinOrtiz;

/**
 * A Markdown parser built on parsedown
 *
 * Class Doxter
 *
 * @package SelvinOrtiz
 */
class Doxter
{
	protected $parser;
	protected $plugin;
	protected $syntaxSnippet;

	public $source		= '' ;
	public $parsed		= '' ;
	public $compiled	= '' ;
	public $codeBlocks	= array();

	public function __construct(array $params=array(), $parser=null)
	{
		$this->parser			= $parser ? $parser : \Parsedown::instance();
		$this->plugin			= \Craft\craft()->plugins->getPlugin('doxter');
		$this->syntaxSnippet	= array_key_exists('syntaxSnippet', $params) ? $params['syntaxSnippet'] : '';
	}

	public function __toString()
	{
		// Always return compiled even if empty to avoid infinite loop @see issue #5
		return $this->compiled;
	}

	public function setSource($source)
	{
		$this->source = $source;

		return $this;
	}

	public function parse()
	{
		$this->parsed = $this->parser->parse($this->source);

		$this->findCodeBlocks();

		return $this;
	}

	public function compile()
	{
		$syntaxSnippet = $this->getSyntaxSnippet();

		if ($this->codeBlocks && !empty($this->parsed))
		{
			foreach ($this->codeBlocks as $block)
			{
				$vars			= array('languageClass'=>$block['lang'], 'sourceCode'=>$block['code']);
				$codeBlock		= $this->renderString($syntaxSnippet, $vars);
				$this->compiled	= str_replace('{{'.$block['id'].'}}', $codeBlock, $this->compiled);
			}
		}

		return $this;
	}

	protected function getSyntaxSnippet()
	{
		// When assigned via the function call available to twig
		if (!empty($this->syntaxSnippet))
		{
			return $this->syntaxSnippet;
		}

		// When assigned via the settings UI
		if (!empty($this->plugin->getSettings()->syntaxSnippet))
		{
			return $this->plugin->getSettings()->syntaxSnippet;
		}

		// When non of the above
		return \Craft\doxter()->getDefaultSyntaxSnippet();
	}

	protected function renderString($str, array $vars=array())
	{
		if (!empty($str) && count($vars))
		{
			foreach ($vars as $var => $val)
			{
				if (is_string($val))
				{
					$str = str_replace('{'.$var.'}', $val, $str);
				}
			}
		}

		return $str;
	}

	protected function findCodeBlocks()
	{
		$regexp = array(
			'/',
			'\<pre\>',
			'\<code class\=\"language-([a-z\-_ ]+)\"\>',
			'\s*?',
			'(.+?)',
			'\<\/code\>',
			'\<\/pre\>',
			'/is'
		);

		$regexp			= implode('', $regexp);
		$this->compiled	= $this->parsed;
		$this->compiled	= preg_replace_callback($regexp, array($this, 'tokenizeCodeBlock'), $this->compiled);

		return $this;
	}

	protected function tokenizeCodeBlock( $matches )
	{
		$lang	= $matches[1] ?: '';
		$code	= $matches[2] ?: '';
		$id		= md5($code);

		$this->addCodeBlock($id, $code, $lang);

		return sprintf('{{%s}}', $id);
	}

	protected function addCodeBlock($id, $code, $lang)
	{
		$this->codeBlocks[] = array('id'=>$id, 'code'=>$code, 'lang'=>$lang );

		return $this;
	}
}
