<?php
namespace Craft;

/**
 * Doxter @v1.0.3
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
		return '1.0.3';
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
		craft()->templates->includeCssResource('doxter/css/doxter.css');
		craft()->templates->includeJsResource('doxter/js/doxter.js');
		craft()->templates->includeJs('new Craft.Doxter();');

		return craft()->templates->render('doxter/settings',
			array(
				'settings' => craft()->doxter->settings,
			)
		);
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
			'codeBlockSnippet'		=> array(AttributeType::String,
				'default'			=> '<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>',
				'column'			=> ColumnType::Text
			),
			'addHeaderAnchors'		=> array(AttributeType::Bool, 'default' => true),
			'addHeaderAnchorsTo'	=> array(AttributeType::String, 'default' => 'h1, h2, h3'),
			'parseReferenceTags'	=> array(AttributeType::Bool,	'default' => true),
			'enableCpTab'			=> array(AttributeType::Bool,	'default' => false),
			'pluginAlias'			=> array(AttributeType::String,	'default' => 'Doxter')
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
