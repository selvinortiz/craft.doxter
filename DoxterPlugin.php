<?php
namespace Craft;

/**
 * Doxter 0.5.4
 *
 * Doxter is a markdown plugin designed to improve your workflow for writing docs
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
		require_once craft()->path->getPluginsPath().'doxter/helpers/DoxterHelper.php';
		require_once craft()->path->getPluginsPath().'doxter/library/vendor/autoload.php';
	}

	/**
	 * Gets the plugin name or alias given by end user
	 *
	 * @param	bool	$real	Whether the real name should be returned
	 * @return	string
	 */
	public function getName($real=false)
	{
		if ($real) { return 'Doxter'; }

		$alias = $this->getSettings()->pluginAlias;

		return empty($alias) ? 'Doxter' : Craft::t($alias);
	}

	public function getVersion()
	{
		return '0.5.4';
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
		craft()->templates->includeCssResource('doxter/doxter.css');
		craft()->templates->includeJsResource('doxter/doxter.js');

		$snippetJs = 'Doxter.addEditorBehavior("syntaxSnippet", 4, false)';

		craft()->templates->includeJs($snippetJs);

		return craft()->templates->render(
			'doxter/_settings',
			array(
				'settings' => $this->getSettings()
			)
		);
	}

	public function hasCpSection()
	{
		return $this->getSettings()->enableCpTab;
	}

	public function defineSettings()
	{
		return array(
			'syntaxSnippet'		=> array(AttributeType::String, 'column'=>ColumnType::Text),
			'enableCpTab'		=> AttributeType::Bool,
			'pluginAlias'		=> AttributeType::String
		);
	}

	public function addTwigExtension()
	{
		Craft::import('plugins.doxter.twigextensions.DoxterTwigExtension');

		return new DoxterTwigExtension();
	}

	public function onAfterInstall()
	{
		craft()->request->redirect(
			sprintf(
				'/%s/settings/plugins/doxter',
				craft()->config->get('cpTrigger')
			)
		);
	}
}
