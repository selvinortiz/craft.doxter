<?php
namespace Craft;

/**
 * This field renders a minimalist yet powerful markdown editor
 *
 * Class DoxterFieldType
 *
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
	 * @see https://github.com/jakiestfu/Behave.js
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$tabs			= $this->getSettings()->getAttribute('enabledSoftTabs') ? 'true' : 'false';
		$tabSize		= $this->getSettings()->getAttribute('tabSize');
		$inputId		= craft()->templates->formatInputId($name);
		$namespacedId	= craft()->templates->namespaceInputId($inputId);

		craft()->templates->includeJsResource('doxter/js/behave.js');

		craft()->templates->includeJs("new Behave(
		{
			textarea: document.getElementById('{$namespacedId}'),
			replaceTabs: true,
			softTabs: {$tabs},
			tabSize: {$tabSize}
		});");

		return craft()->templates->renderMacro('_includes/forms', 'textarea', array(
			array(
				'id'    => $inputId,
				'name'  => $name,
				'value' => $value,
				'class' => 'nicetext code doxter',
				'rows'  => $this->getSettings()->getAttribute('rows')
			)
		));
	}

	/**
	 * @return array
	 */
	public function defineSettings()
	{
		return array(
			'enableSoftTabs'	=> array(AttributeType::Bool,	'maxLength'	=> 3, 'default' => true),
			'tabSize'			=> array(AttributeType::Number,	'default'	=> 4),
			'rows'				=> array(AttributeType::Number,	'default'	=> 4)
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

	/**
	 * @return array
	 */
	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column' => ColumnType::LongText);
	}
}
