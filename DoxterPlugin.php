<?php
namespace Craft;

/**
 * Doxter @v1.0.1
 *
 * The swiss army markdown plugin
 *
 * @author		Selvin Ortiz - http://selvinortiz.com
 * @package		Doxter
 * @category	Markdown
 * @copyright	2014 Selvin Ortiz
 * @license		[MIT]
 */

class DoxterPlugin extends BasePlugin
{
	/**
	 * Imports custom library and listens for desired events
	 *
	 * @throws \Exception
	 */
	public function init()
	{
		parent::init();

		Craft::import('plugins.doxter.common.*');
		Craft::import('plugins.doxter.twigextensions.*');

		require_once(dirname(__FILE__).'/common/libs/Parsedown.php');
	}

	/**
	 * Returns the plugin name or the plugin alias assigned by the end user
	 *
	 * @param bool $real Whether the real name should be returned
	 *
	 * @return string
	 */
	public function getName($real=false)
	{
		$name	= 'Doxter';
		$alias	= $this->getSettings()->getAttribute('pluginAlias');

		return ($real || empty($alias)) ? $name : $alias;
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '1.0.1';
	}

	/**
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Selvin Ortiz';
	}

	/**
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'http://selvinortiz.com';
	}

	/**
	 * Returns a rendered view for plugin settings
	 *
	 * @return string The html content
	 */
	public function getSettingsHtml()
	{
		if (craft()->doxter->getEnvOption('useCompressedResources', true))
		{
			craft()->templates->includeCssResource('doxter/css/doxter.min.css');
			craft()->templates->includeJsResource('doxter/js/doxter.min.js');
		}
		else
		{
			craft()->templates->includeCssResource('doxter/css/doxter.css');
			craft()->templates->includeJsResource('doxter/js/textrange.js');
			craft()->templates->includeJsResource('doxter/js/behave.js');
			craft()->templates->includeJsResource('doxter/js/doxter.js');
		}

		craft()->templates->includeJs($this->getSnippetJs());

		return craft()->templates->render(
			'doxter/_settings',
			array(
				'settings' => craft()->doxter->settings,
			)
		);
	}

	public function getSnippetJs()
	{
		$options = json_encode(array(
			'tabSize'	=> 4,
			'softTabs'	=> false
		));

		return "new Doxter('codeBlockSnippet', {$options});";
	}

	/**
	 * Whether a control panel tab should be display for Doxter
	 *
	 * @return bool
	 */
	public function hasCpSection()
	{
		return $this->getSettings()->getAttribute('enableCpTab');
	}

	/**
	 * The main plugin settings
	 *
	 * @return array
	 */
	public function defineSettings()
	{
		return array(
			/*
			 * Whether recursive parsing should be enabled in parsers that support it
			 */
			'parseRecursively'		=> array(AttributeType::Bool, 'default' => true),

			/*
			 * Whether headers should be parsed and anchored
			 */
			'addHeaderAnchors'		=> array(AttributeType::Bool, 'default' => true),

			/*
			 * The headers that should be parsed and anchored if header parsing is enabled
			 */
			'addHeaderAnchorsTo'	=> array(AttributeType::String, 'default' => 'h1, h2, h3'),

			/*
			 * The snippet used to wrap fenced code blocks in {languageClass} {sourceCode}
			 */
			'codeBlockSnippet'		=> array(AttributeType::String,
				'default'			=> '<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>',
				'column'			=> ColumnType::Text
			),

			/*
			 * Whether reference tags should be parsed {type:reference:property}
			 */
			'parseReferenceTags'	=> array(AttributeType::Bool, 'default' => true),
			
			/*
			 * Whether a tab with the name/alias should be shown in the CP nav
			 */
			'enableCpTab'			=> array(AttributeType::Bool, 'default' => false),
			
			/*
			 * The plugin alias to use in place of the name in the CP tab, plugin settings, etc.
			 */
			'pluginAlias'			=> array(AttributeType::String, 'default' => 'Doxter')
		);
	}

	/**
	 * @return object The twig extension instance
	 * @throws \Exception
	 */
	public function addTwigExtension()
	{
		return new DoxterTwigExtension;
	}

	/**
	 * Takes desired actions after plugin installation
	 */
	public function onAfterInstall()
	{
		craft()->request->redirect(UrlHelper::getCpUrl('settings/plugins/doxter'));
	}
}
