<?php
namespace Craft;

/**
 * The DoxterFieldType class in charge of rendering inputs and settings.
 *
 * @class DoxterFieldType
 * @package Craft
 */
class DoxterFieldType extends BaseFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return 'Doxter Markdown';
	}

	/**
	 * Returns the rendered html for the fieldtype UI
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		craft()->templates->includeCssResource('doxter/css/doxter.css');
		craft()->templates->includeJsResource('doxter/js/ace.js');
		craft()->templates->includeJsResource('doxter/js/doxter.js');

		$inputId	= craft()->templates->formatInputId($name);
		$targetId	= craft()->templates->namespaceInputId($inputId);
		$snippetJs	= $this->getDoxterFieldJs($targetId);

		craft()->templates->includeJs($snippetJs);

		return craft()->templates->render('doxter/fields/doxter/input',
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
			'enableSoftTabs'	=> array(AttributeType::Bool, 'maxLength' => 3, 'default' => true),
			'tabSize'			=> array(AttributeType::Number, 'default' => 4),
			'rows'				=> array(AttributeType::Number, 'default' => 20)
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('doxter/fields/doxter/settings',
			array(
				'settings' => $this->getSettings()
			)
		);
	}

	/**
	 * @param string $id The field (html) id
	 *
	 * @return string
	 */
	public function getDoxterFieldJs($id)
	{
		$options = json_encode(
			array(
				'rows'		=> $this->getSettings()->getAttribute('rows'),
				'tabSize'	=> $this->getSettings()->getAttribute('tabSize'),
				'softTabs'	=> $this->getSettings()->getAttribute('enableSoftTabs'),
				'container'	=> $id.'Canvas'
			)
		);

		return "new Craft.DoxterFieldType('{$id}', {$options}).render();";
	}

	/**
	 * @param mixed $value
	 *
	 * @return DoxterModel
	 */
	public function prepValue($value)
	{
		$model = DoxterModel::create();

		if (!empty($value))
		{
			$model->setAttribute('text', $value);
			$model->setAttribute('html', doxter()->parse($value));
		}

		return $model;
	}

	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column' => ColumnType::LongText);
	}
}
