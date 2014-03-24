<?php
namespace Craft;

/**
 * Write markdown in live preview and create reference tags with ease
 *
 * @package Craft
 */
class DoxterFieldType extends BaseFieldType
{
	public function getName()
	{
		return 'Doxter Markdown';
	}

	public function getInputHtml($name, $value)
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

		$inputId	= craft()->templates->formatInputId($name);
		$targetId	= craft()->templates->namespaceInputId($inputId);
		$snippetJs	= $this->getDoxterFieldJs($targetId);

		// Using the lovely Craft queue/buffer to support matrix fields: )
		craft()->templates->includeJs($snippetJs);

		return craft()->templates->render(
			'doxter/fields/doxter/_input',
			array(
				'id'		=> $targetId,
				'name'		=> $name,
				'value'		=> $value,
				'inputId'	=> $inputId,
				'settings'	=> $this->getSettings()
			)
		);
	}

	public function defineSettings()
	{
		return array(
			'enableWordWrap'	=> array(AttributeType::Bool, 'maxLength' => 3, 'default' => false),
			'enableSoftTabs'	=> array(AttributeType::Bool, 'maxLength' => 3, 'default' => true),
			'spellcheck'		=> array(AttributeType::Bool, 'maxLength' => 3, 'default' => false),
			'tabSize'			=> array(AttributeType::Number, 'default' => 4),
			'rows'				=> array(AttributeType::Number, 'default' => 20)
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

	public function getDoxterFieldJs($id)
	{
		$options = json_encode(
			array(
				'tabSize'	=> doxter()->plugin->getSettings()->getAttribute('tabSize'),
				'softTabs'	=> doxter()->plugin->getSettings()->getAttribute('enableSoftTabs'),
				'container'	=> $id.'Canvas'
			)
		);

		return "new Doxter('{$id}', {$options}).render();";
	}

	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column'=>ColumnType::LongText);
	}
}
