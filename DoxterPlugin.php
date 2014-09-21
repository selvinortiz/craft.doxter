<?php
namespace Craft;

/**
 * Doxter @v1.0.3
 *
 * Documentation friendly markdown editing and parsing
 *
 * @author		Selvin Ortiz - http://selvinortiz.com
 * @package		Craft
 * @category	Doxter, Markdown
 * @copyright	2014 Selvin Ortiz
 * @license		MIT Copyright (c) 2014 Selvin Ortiz
 */

class DoxterPlugin extends BasePlugin
{
	/**
	 * Imports custom classes when the plugin is initialized
	 *
	 * @throws \Exception
	 */
	public function init()
	{
		parent::init();

		Craft::import('plugins.doxter.common.*');
		Craft::import('plugins.doxter.twigextensions.*');

		require_once(dirname(__FILE__).'/common/parsedown/Parsedown.php');
		require_once(dirname(__FILE__).'/common/parsedown/ParsedownExtra.php');
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
				'settings' => $this->getSettings(),
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
	 * @return array
	 */
	public function defineSettings()
	{
		return array(
			'codeBlockSnippet'				=> array(AttributeType::String, 'default' => $this->getCodeBlockSnippet(), 'column' => ColumnType::Text),
			'addHeaderAnchors'				=> array(AttributeType::Bool,	'default' => true),
			'addHeaderAnchorsTo'			=> array(AttributeType::String,	'default' => array('h1', 'h2', 'h3')),
			'parseReferenceTags'			=> array(AttributeType::Bool,	'default' => true),
			'parseReferenceTagsRecursively'	=> array(AttributeType::Bool,	'default' => true),
			'enableCpTab'					=> array(AttributeType::Bool,	'default' => false),
			'pluginAlias'					=> array(AttributeType::String,	'default' => 'Doxter')
		);
	}

	public function prepSettings($settings=array())
	{
		$settings['addHeaderAnchorsTo'] = craft()->doxter->getHeadersToParse($settings['addHeaderAnchorsTo']);

		return $settings;
	}

	/**
	 * Returns the default code block snippet to use
	 *
	 * @access protected
	 * @return string
	 */
	public function getCodeBlockSnippet()
	{
		return '<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>';
	}

	/**
	 * Adds
	 * @return DoxterTwigExtension
	 * @throws \Exception
	 */
	public function addTwigExtension()
	{
		return new DoxterTwigExtension();
	}

	/**
	 * Redirects to the plugin settings screen after installation
	 */
	public function onAfterInstall()
	{
		craft()->request->redirect(UrlHelper::getCpUrl('settings/plugins/doxter'));
	}
}

/**
 * Enables us to have a single point of access to our service layer and proper hinting
 *
 * @return DoxterService
 */
function doxter()
{
	return craft()->doxter;
}
