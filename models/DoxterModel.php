<?php
namespace Craft;

/**
 * Represents text (source) and html (output) for the field type value
 *
 * Class DoxterModel
 *
 * @package Craft
 */
class DoxterModel extends BaseModel
{
	/**
	 * Returns an instance of self which improves testability
	 *
	 * @return DoxterModel
	 */
	public static function create()
	{
		return new self;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getText();
	}

	/**
	 * Returns the field type text (markdown source)
	 *
	 * @return string
	 */
	public function getText()
	{
		return !empty($this->text) ? $this->text : '';
	}

	/**
	 * Alias of parse()
	 *
	 * @see parse()
	 * @param array $options
	 *
	 * @return \Twig_Markup
	 */
	public function getHtml(array $options=array())
	{
		return $this->parse($options);
	}

	/**
	 * Returns the field type html (parsed output)
	 *
	 * @param array $options Parsing options if any
	 *
	 * @return \Twig_Markup
	 */
	public function parse(array $options=array())
	{
		$html = (array() === $options) ? $this->getAttribute('html') : doxter()->parse($this->getAttribute('text'), $options);

        return TemplateHelper::getRaw(typogrify($html));
	}

	public function defineAttributes()
	{
		return array(
			'text'	=> AttributeType::String,
			'html'	=> AttributeType::String,
		);
	}
}
