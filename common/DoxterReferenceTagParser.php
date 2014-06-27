<?php
namespace Craft;

/**
 * Doxter Reference Parser
 *
 * @package SelvinOrtiz
 */
class DoxterReferenceTagParser extends DoxterBaseParser
{
	protected static $instance;
	protected static $openingTag	= '{';
	protected static $closingTag	= '}';
	protected static $references	= array(
		'category'	=> ElementType::Category,
		'global'	=> ElementType::GlobalSet,
		'entry'		=> ElementType::Entry,
		'asset'		=> ElementType::Asset,
		'user'		=> ElementType::User,
		'tag'		=> ElementType::Tag,
	);

	/**
	 * The content parsed after each iteration used to beak out of recursive parsing
	 *
	 * @var	string
	 */
	protected $parsedContent;

	/**
	 * Returns the pattern for matching reference tags within Doxter fields
	 *
	 * @return string
	 */
	protected function getPattern()
	{
		$references = implode('|', array_keys(static::$references));

		return 	sprintf('/%s(%s):([a-z0-9\@\.\-\_\/]+):?(.+)?%s/i', static::$openingTag, $references, static::$closingTag);

	}

	/**
	 * Parses reference tags recursively (optional)
	 *
	 * @param string $source
	 * @param array $options
	 *
	 * @return	string
	 */
	public function parse($source, array $options=array())
	{
		if (!$this->canBeSafelyParsed($source) || stripos($source, '{') === false)
		{
			return $source;
		}

		$source	= preg_replace_callback(static::getPattern(), array($this, 'handleTagMatch'), $source);

		if (isset($options['parseReferenceTagsRecursively']) && $options['parseReferenceTagsRecursively'])
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

	/**
	 *
	 * @param array $tags
	 * @param mixed $default
	 *
	 * @return BaseElementModel|mixed
	 */
	public function getTagContent(array $tags=array(), $default=null)
	{
		$elementType		= $tags[0];
		$elementCriteria	= $tags[1];
		$elementString		= isset($tags[2]) ? $tags[2] : false;
		$element			= $this->getElementByReferenceTag($elementType, $elementCriteria);

		if ($element)
		{
			if ($elementString)
			{
				$elementString	= '{'.$elementString.'}';

				try
				{
					return craft()->templates->renderObjectTemplate($elementString, $element);
				}
				catch(\Exception $e)
				{
					return $default;
				}
			}

			return $element;
		}

		return $default;
	}

	/**
	 * @param string $elementType (category|global|entry|user|asset|tag)
	 * @param string $elementCriteria (10|section/slug|user@domain.com)
	 *
	 * @return BaseElementModel|null
	 */
	public function getElementByReferenceTag($elementType, $elementCriteria)
	{
		$criteria		= array('limit' => 1);
		$elementType	= strtolower($elementType);

		if (!array_key_exists($elementType, static::$references))
		{
			return false;
		}

		switch ($elementType)
		{
			case 'entry':
			{
				$elementCriteria = array_map('trim', explode('/', $elementCriteria));

				if (count($elementCriteria) == 1)
				{
					$criteria['id'] = (int) $elementCriteria[0];
				}
				elseif (count($elementCriteria) == 2)
				{
					$criteria['section']	= $elementCriteria[0];
					$criteria['slug']		= $elementCriteria[1];
				}

				break;
			}
			case 'user':
			{
				if (stripos($elementCriteria, '@'))
				{
					$criteria['email'] = $elementCriteria;
				}
				elseif (is_numeric($elementCriteria))
				{
					$criteria['id'] = (int) $elementCriteria;
				}
				else
				{
					$criteria['username'] = $elementCriteria;
				}

				break;
			}
			default:
			{
				$criteria['id'] = $elementCriteria;
				break;
			}
		}

		return craft()->elements->getCriteria(static::$references[$elementType])->first($criteria);
	}
}
