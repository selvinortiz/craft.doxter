<?php
namespace Craft;

/**
 * The service layer and global API into Doxter
 *
 * Class DoxterService
 *
 * @package Craft
 */

class DoxterService extends BaseApplicationComponent
{
	/**
	 * @var array The plugin settings imported on service initialization
	 */
	public $settings	= array();

	/**
	 * Loads plugin settings into self for later use
	 *
	 * @return void
	 */
	public function init()
	{
		parent::init();

		$this->settings = craft()->plugins->getPlugin('doxter')->getSettings()->getAttributes();
	}

	/**
	 * Parses source markdown into valid html using various rules and parsers
	 *
	 * @param string $source The markdown source to parse
	 * @param array $params Passed in parameters via a template call
	 *
	 * @return \Twig_Markup The parsed content flagged as safe to output
	 */
	public function parse($source, array $params=array())
	{
		$codeBlockSnippet				= null;
		$addHeaderAnchors				= true;
		$addHeaderAnchorsTo				= array('h1', 'h2', 'h3');
		$parseReferenceTags				= true;
		$parseReferenceTagsRecursively	= true;

		$params = array_merge($this->settings, $params);

		extract($params);

		// By parsing reference tags first, we have a chance to parse md within them
		if ($parseReferenceTags)
		{
			$source = DoxterReferenceTagParser::instance()->parse($source, compact('parseReferenceTagsRecursively'));
		}

		$source	= \Parsedown::instance()->text($source);
		$source	= DoxterCodeParser::instance()->parse($source, compact('codeBlockSnippet'));

		if ($addHeaderAnchors)
		{
			$source = DoxterHeaderParser::instance()->parse($source, compact('addHeaderAnchorsTo'));
		}

		return TemplateHelper::getRaw($source);
	}

	public function getBoolFromLightSwitch($value)
	{
		if (is_bool($value))
		{
			return $value;
		}

		switch (strtolower($value))
		{
			case '1':
			case 'y':
			case 'on':
			case 'yes':
				return true;
			break;
			default:
				return false;
			break;
		}
	}

	public function getEnvOption($option=null, $default=null)
	{
		$env	= craft()->config->get('doxterSettings');
		$opts 	= array();

		// Settings not available
		if (is_null($env))
		{
			return $default;
		}

		// Option not provided
		if (is_null($option))
		{
			return $env;
		}

		if (is_string($option))
		{
			$opts = array_map('trim', explode('.', $option));
		}

		if (count($opts))
		{
			foreach ($opts as $opt)
			{
				if (array_key_exists($opt, $env))
				{
					$env = $env[$opt]; continue;
				}

				return $default;
			}
		}

		return $env;
	}
}
