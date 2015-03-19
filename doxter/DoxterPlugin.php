<?php
namespace Craft;

/**
 * Doxter @v1.0.5
 *
 * Documentation friendly markdown for Craft
 *
 * @author         Selvin Ortiz - http://selv.in
 * @package        Craft
 * @copyright      2014 Selvin Ortiz
 * @license        MIT Copyright (c) 2014 Selvin Ortiz
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
		require_once(dirname(__FILE__).'/common/parsedown/Typography.php');
	}

	/**
	 * Returns the plugin name or the plugin alias assigned by the end user
	 *
	 * @param bool $real Whether the real name should be returned
	 *
	 * @return string
	 */
	public function getName($real = false)
	{
		$alias = $this->getSettings()->getAttribute('pluginAlias');

		return ($real || empty($alias)) ? 'Doxter' : $alias;
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '1.0.5';
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
		return 'http://selv.in';
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
	 * Returns a rendered view for plugin settings
	 *
	 * @return string
	 */
	public function getSettingsHtml()
	{
		craft()->templates->includeCssResource('doxter/css/doxter.css');
		craft()->templates->includeJsResource('doxter/js/doxter.js');
		craft()->templates->includeJs('new Craft.Doxter();');

		return craft()->templates->render(
			'doxter/settings',
			array(
				'settings' => $this->getSettings(),
			)
		);
	}

	/**
	 * @return array
	 */
	public function defineSettings()
	{
		return array(
			'codeBlockSnippet'              => array(
				AttributeType::String,
				'default' => $this->getCodeBlockSnippet(),
				'column'  => ColumnType::Text
			),
			'addHeaderAnchors'              => array(AttributeType::Bool, 'default' => true),
			'addHeaderAnchorsTo'            => array(AttributeType::String, 'default' => array('h1', 'h2', 'h3')),
			'parseReferenceTags'            => array(AttributeType::Bool, 'default' => true),
			'parseReferenceTagsRecursively' => array(AttributeType::Bool, 'default' => true),
			'enableCpTab'                   => array(AttributeType::Bool, 'default' => false),
			'pluginAlias'                   => array(AttributeType::String, 'default' => 'Doxter')
		);
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function prepSettings($settings = array())
	{
		$settings['addHeaderAnchorsTo'] = doxter()->getHeadersToParse($settings['addHeaderAnchorsTo']);

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
	 * @throws \Exception
	 * @return DoxterTwigExtension
	 */
	public function addTwigExtension()
	{
		return new DoxterTwigExtension();
	}
}

/**
 * Enables us to have a single point of access to our service layer and proper hinting
 *
 * @return DoxterService
 */
function doxter()
{
	return Craft::app()->getComponent('doxter');
}
