<?php
namespace SelvinOrtiz;

class Doxter extends \Michelf\MarkdownExtra
{
	protected $plugin;
	protected $syntaxSnippet;

	public $source		= '' ;
	public $parsed		= '' ;
	public $compiled	= '' ;
	public $codeBlocks	= array();

	public function __construct(array $params=array())
	{
		// Making sure parent gets initialized properly
		parent::__construct();

		// Grabbing the plugin for future use
		$this->plugin = \Craft\craft()->plugins->getPlugin('doxter');

		// Load passed in params for future use
		$this->syntaxSnippet = array_key_exists('syntaxSnippet', $params) ? $params['syntaxSnippet'] : '';
	}

	public function __toString()
	{
		if (empty($this->compiled))
		{
			return (string) $this->parse()->compile();
		}

		return $this->compiled;
	}

	public function setSource($source)
	{
		$this->source = $source;

		return $this;
	}

	public function parse()
	{
		$this->parsed = $this->transform($this->source);

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
		return '<pre><code data-language="{languageClass}">{sourceCode}</code></pre>';
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
			'\<code class\=\"([a-z\-_ ]+)\"\>',
			'\s*?',
			'(.+?)',
			'\<\/code\>',
			'\<\/pre\>',
			'/is'
		);

		$regexp			= implode('', $regexp);
		$this->compiled	= $this->parsed;
		$this->compiled	= html_entity_decode($this->parsed); // Removes annoying encoded entities;
		$this->compiled	= preg_replace_callback($regexp, array($this, 'tokenizeCodeBlock'), $this->compiled);

		return $this;
	}

	protected function tokenizeCodeBlock( $matches )
	{
		$lang	= $matches[1] ?: '';
		$code	= $matches[2] ?: '';
		$code	= preg_replace('/^\<br\s?\/?\>/i', '', $code, 1); // Removes annoying <br /> from start of code block
		$id		= md5( $code );

		$this->addCodeBlock($id, $code, $lang);

		return sprintf('{{%s}}', $id);
	}

	protected function addCodeBlock($id, $code, $lang)
	{
		$code = htmlentities(preg_replace('/^\<br\s*?\/?\>/is', '', $code));
		$this->codeBlocks[] = array('id'=>$id, 'code'=>$code, 'lang'=>$lang );

		return $this;
	}

	/**
	 * Editing the fenced code block syntax to match style used by github
	 *
	 * ``` php
	 *
	 * <pre class="php"><code data-language="php">echo 'Hello World.';</code></pre>
	 *
	 * ```
	 */
	protected function doFencedCodeBlocks( $text )
	{
		$text = preg_replace_callback('{
				(?:\n|\A)
				# 1: Opening marker
				(
					`{3,} # Marker: three (tilde) apostrophe or more.
				)
				[ ]*
				(?:
					\.?([-_:a-zA-Z0-9]+) # 2: standalone class name
				|
					'.$this->id_class_attr_catch_re.' # 3: Extra attributes
				)?
				[ ]* \n # Whitespace and newline following marker.

				# 4: Content
				(
					(?>
						(?!\1 [ ]* \n)	# Not a closing marker.
						.*\n+
					)+
				)

				# Closing marker.
				\1 [ ]* \n
			}xm',
			array( &$this, '_doFencedCodeBlocks_callback'), $text);

		return $text;
	}
}
