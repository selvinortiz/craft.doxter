<?php
namespace SelvinOrtiz\Doxter;

use \Craft\ElementType;
use \Craft\ContentModel;
use \Craft\BaseElementModel;
use \Craft\ElementCriteriaModel;

/**
 * Doxter Reference Parser
 *
 * @package SelvinOrtiz
 */
class ReferenceTagParser extends Parser
{
	protected static $pattern = '(entry|user|asset|tag|global):([a-z0-9\@\.\-\_\/]+):?([a-z0-9\-\_\.\(\)]+)?';
	protected static $openingTag = '{';
	protected static $closingTag = '}';

	/**
	 * The content parsed after each iteration used to beak out of recursive parsing
	 *
	 * @var	string
	 */
	protected $parsedContent;

	/**
	 * Parses reference tags recursively (optional)
	 *
	 * @param	string	$source
	 * @param	boolean	$recursively
	 *
	 * @return	string
	 */
	public function parse($source = null, $recursively = true)
	{
		if (!$this->isValidString($source) || stripos($source, '{') === false)
		{
			return $source;
		}

		$pattern	= sprintf('/%s%s%s/i', self::$openingTag, self::$pattern, self::$closingTag);
		$source		= preg_replace_callback($pattern, array($this, 'handleTagMatch'), $source);

		if (!$recursively)
		{
			return $source;
		}

		if ($this->parsedContent === $source)
		{
			return $source;
		}

		$this->parsedContent = $source;

		return $this->parse($source);
	}

	public function handleTagMatch(array $matches = array())
	{
		$matched = array_shift($matches);
		$content = $this->getTagContent($matches, $matched);

		return is_null($content) ? $matched : $content;
	}

	public function getTagContent(array $tags = array(), $default = null)
	{
		$type			= $tags[0];
		$reference		= $tags[1];
		$attribute		= isset($tags[2]) ? $tags[2] : false;
		$attributes		= array();
		$elementType	= null;

		switch (strtolower($type))
		{
			case 'entry':
				$elementType	= ElementType::Entry;
				$reference		= array_map('trim', explode('/', $reference));

				if (count($reference) == 1)
				{
					$attributes['id'] = (int) $reference[0];
				}
				elseif (count($reference) == 2)
				{
					$attributes['slug']		= $reference[1];
					$attributes['section']	= $reference[0];
				}

				break;

			case 'user':
				$elementType = ElementType::User;

				if (stripos($reference, '@'))
				{
					$attributes['email'] = $reference;
				}
				elseif (is_numeric($reference))
				{
					$attributes['id'] = (int)$reference;
				}
				else
				{
					$attributes['username'] = $reference;
				}

				break;

			case 'tag':
				$elementType	= ElementType::Tag;
			case 'asset':
				$elementType	= $elementType ? $elementType : ElementType::Asset;
			case 'global':
				$elementType	= $elementType ? $elementType : ElementType::GlobalSet;
				$attributes		= array('id' => (int)$reference);

				break;
		}

		$element	= $this->getElement($elementType, $attributes);

		if ($element)
		{
			$elementContent = $element->getContent();

			if ($attribute)
			{
				return $this->getElementAttribute($attribute, $element, $elementContent, $default);
			}

			return $element;
		}

		return $default;
	}

	public function getElement($type, $attributes, $criteria = null)
	{
		$element = \Craft\craft()->elements->getCriteria($type, $attributes)->find($criteria);

		if ($element)
		{
			return array_shift($element);
		}

		return false;
	}

	public function getElementAttribute($attribute, BaseElementModel $element, ContentModel $content, $default = false)
	{
		$comparisonKey	= md5(time());
		$attributeValue	= $this->getAttribute($attribute, $element, $comparisonKey);

		if ($attributeValue !== $comparisonKey)
		{
			return $attributeValue;
		}

		return $this->getAttribute($attribute, $content, $default);
	}

	/**
	 * Will attempt to grab the attribute value of an element
	 *
	 * @param	string	$attribute	The special (attr|attr()|attr.sub) attribute name
	 * @param	mixed	$model		The instance of BaseElementModel or ContentElementModel
	 * @param	mixed	$default
	 *
	 * @return	string
	 */
	protected function getAttribute($attribute, $model, $default = null)
	{
		$attributes = is_array($attribute) ? $attribute : array_map('trim', explode('.', $attribute));

		foreach ($attributes as $attributeName)
		{
			$attributeName = preg_replace('/\(.*?\)/i', '', $attributeName);

			if (isset($model->{$attributeName}))
			{
				$model = $model->{$attributeName};
			}
			elseif (method_exists($model, $attributeName))
			{
				$model = $model->{$attributeName}();
			}
			else
			{
				return $default;
			}

			if ($model instanceof ElementCriteriaModel)
			{
				$model = $model->first();
			}
		}

		return $model;
	}
}
