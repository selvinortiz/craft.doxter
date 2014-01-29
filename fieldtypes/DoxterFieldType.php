<?php
namespace Craft;

/**
 * Doxter Markdown allows you to write and preview markdown in a very clean and simple way
 *
 * @package Craft
 */
class DoxterFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('Doxter Markdown');
	}

	public function getInputHtml($name, $value)
	{
		$plugin		= craft()->plugins->getPlugin('doxter');
		$inputId	= craft()->templates->formatInputId($name);
		$targetId	= craft()->templates->namespaceInputId($inputId);
		$snippetJs	= $this->getDoxterMarkdownJs($targetId, $this->getSettings());

		if ($plugin->getDevMode())
		{
			craft()->templates->includeCssResource('doxter/css/fields/doxter/editor.css');
			craft()->templates->includeCssResource('doxter/css/fields/doxter/syntax.css');
			craft()->templates->includeCssResource('doxter/css/fields/doxter/input.css');
			craft()->templates->includeJsResource('doxter/js/min/jquery.min.js');
			craft()->templates->includeJsResource('doxter/js/min/jquery.caret.min.js');
			craft()->templates->includeJsResource('doxter/js/min/jquery.scroll.min.js');
			craft()->templates->includeJsResource('doxter/js/min/easytabs.min.js');
			craft()->templates->includeJsResource('doxter/js/min/marked.min.js');
			craft()->templates->includeJsResource('doxter/js/min/rainbow.min.js');
			craft()->templates->includeJsResource('doxter/js/min/crevasse.min.js');
			craft()->templates->includeJsResource('doxter/js/min/behave.min.js');
			craft()->templates->includeJsResource('doxter/js/min/doxter.min.js');
		}
		else
		{
			craft()->templates->includeCssResource('doxter/doxter.css');
			craft()->templates->includeJsResource('doxter/doxter.js');
		}

		// Using the lovely Craft queue/buffer to support matrix fields: )
		craft()->templates->includeJs($snippetJs);

		return craft()->templates->render(
			'doxter/fields/doxter/_input',
			array(
				'id'				=> $targetId,
				'name'				=> $name,
				'value'				=> $value,
				'inputId'			=> $inputId,
				'settings'			=> $this->getSettings()
			)
		);
	}

	public function defineSettings()
	{
		return array(
			'enableWordWrap'	=> array(AttributeType::Bool, 'maxLength'=>3),
			'enableSoftTabs'	=> array(AttributeType::Bool, 'maxLength'=>3),
			'tabSize'			=> AttributeType::Number
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render(
			'doxter/fields/doxter/_settings',
			array(
				'settings' => $this->getSettings()
			)
		);
	}

	public function getDoxterMarkdownJs($id, $settings)
	{
		return "Doxter.createDoxterMarkdown('{$id}', {$settings->tabSize}, {$settings->enableSoftTabs});";
	}

	public function prepSettings($settings)
	{
		$settings['enableWordWrap'] = craft()->doxter->getBoolFromLightSwitch($settings['enableWordWrap']);
		$settings['enableSoftTabs'] = craft()->doxter->getBoolFromLightSwitch($settings['enableSoftTabs']);

		return $settings;
	}

	/**
	 * prepValueFromPost()
	 *
	 * This allows us to manipulate the $value from/for the content table
	 * This gives access to the $_POST as well to manipulate before the entry is saved
	 *
	 * @param	Mixed	$value	This value will be null if no content column is defined
	 * @return	Mixed			Modified $value
	 */
	public function prepValueFromPost($value)
	{
		return $value;
	}

	public function prepValue($value)
	{
		return $value;
	}

	/**
	 * @EVENTS
	 */
	public function onBeforeSave()	{}

	public function onAfterSave()	{}

	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column'=>ColumnType::LongText);
	}
}
