<?php
namespace Craft;

/**
 * The DoxterFieldType model that represents text (source) and html (output) for field values
 *
 * Class DoxterModel
 *
 * @package Craft
 */
class DoxterModel extends BaseModel
{
	/**
	 * Returns an instance of sef which improves testability
	 *
	 * @return DoxterModel
	 */
	public static function create()
	{
		return new self;
	}

	/**
	 * @return string The source markdown string
	 */
	public function __toString()
	{
		return $this->getText();
	}

	/**
	 * Returns the markdown source
	 *
	 * @return string
	 */
	public function getText()
	{
		return !empty($this->text) ? $this->text : '';
	}

	/**
	 * Returns raw html converted from the source markdown for the fieldtype
	 *
	 * @param array $options Parsing options
	 *
	 * @return \Twig_Markup
	 */
	public function getHtml(array $options=array())
	{
		if (count($options))
		{
			return $this->parse($options);
		}

		return $this->html;
	}

	/**
	 * Alias for getHtml()
	 *
	 * @see getHtml()
	 * @param array $options
	 *
	 * @return \Twig_Markup
	 */
	public function parse(array $options=array())
	{
		return craft()->doxter->parse($this->text, $options);
	}

	public function defineAttributes()
	{
		return array(
			'text'	=> AttributeType::String,
			'html'	=> AttributeType::String,
		);
	}
}
