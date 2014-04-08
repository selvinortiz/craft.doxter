<?php
namespace Craft;

/**
 * Doxter @v0.6.2
 *
 * Doxter is a markdown plugin designed to improve the way you write documentation
 *
 * @author		Selvin Ortiz - http://twitter.com/selvinortiz
 * @package		Doxter
 * @category	Markdown
 * @copyright	2014 Selvin Ortiz
 * @license		[MIT]
 */

class DoxterPlugin extends BasePlugin
{
	public function init()
	{
		$bootstrap = craft()->path->getPluginsPath().'doxter/library/vendor/autoload.php';

		if (!file_exists($bootstrap))
		{
			throw new Exception(Craft::t('Please download the latest release or read the install notes'));
		}

		require_once $bootstrap;

		// Load the dependency container
		doxter()->stash('plugin', $this);
		doxter()->stash('service', craft()->doxter);
		doxter()->init();
	}

	public function getName($real=false)
	{
		$name	= 'Doxter';
		$alias	= $this->getSettings()->pluginAlias;

		if ($real)
		{
			return $name;
		}

		return empty($alias) ? $name : $alias;
	}

	public function getVersion()
	{
		return '0.6.2';
	}

	public function getDeveloper()
	{
		return 'Selvin Ortiz';
	}

	public function getDeveloperUrl()
	{
		return 'http://twitter.com/selvinortiz';
	}

	public function getSettingsHtml()
	{
		if (doxter()->service->getEnvOption('useCompressedResources', true))
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
				'settings' => doxter()->plugin->getSettings()
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

	public function hasCpSection()
	{
		return $this->getSettings()->getAttribute('enableCpTab');
	}

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

	public function addTwigExtension()
	{
		Craft::import('plugins.doxter.twigextensions.DoxterTwigExtension');

		doxter()->stash('extension', new DoxterTwigExtension());

		return doxter()->extension;
	}

	public function onAfterInstall()
	{
		craft()->request->redirect($this->getCpSettingsUrl());
	}

	public function getCpUrl($append='')
	{
		return sprintf('/%s/doxter/%s', craft()->config->get('cpTrigger'), $append);
	}

	public function getCpSettingsUrl($append='')
	{
		return sprintf('/%s/settings/plugins/doxter/%s', craft()->config->get('cpTrigger'), $append);
	}
}

/**
 * A way to grab the dependency container within the Craft namespace
 */
if (!function_exists('\\Craft\\doxter'))
{
	function doxter()
	{
		return \SelvinOrtiz\Doxter\Doxter::getInstance();
	}
}
