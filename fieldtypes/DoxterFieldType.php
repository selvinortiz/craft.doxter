<?php
namespace Craft;

/**
 * Doxter allows you to write markdown and supports live preview
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

		craft()->templates->includeCssResource('doxter/doxter.css');
		craft()->templates->includeJsResource('doxter/doxter.js');

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
			'tabSize'			=> AttributeType::Number,
			'rows'				=> AttributeType::Number
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
		// I prefer sensible defautls instead of errors for this use case
		$settings['enableWordWrap'] = craft()->doxter->getBoolFromLightSwitch($settings['enableWordWrap']);
		$settings['enableSoftTabs'] = craft()->doxter->getBoolFromLightSwitch($settings['enableSoftTabs']);
		$settings['syntaxSnippet']	= doxter()->get('syntaxSnippet', $settings, doxter()->getDefaultSyntaxSnippet());
		$settings['tabSize']		= doxter()->get('tabSize', $settings, 4);
		$settings['rows']			= doxter()->get('rows', $settings, 20);

		return $settings;
	}

	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column'=>ColumnType::LongText);
	}
}
