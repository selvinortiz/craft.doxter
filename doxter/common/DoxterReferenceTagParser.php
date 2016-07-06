<?php
namespace Craft;

/**
 * Class DoxterReferenceTagParser
 *
 * @package Craft
 */
class DoxterReferenceTagParser extends DoxterBaseParser
{
    /**
     * @var DoxterReferenceTagParser
     */
    protected static $instance;

    protected static $openingTag = '{';
    protected static $closingTag = '}';
    protected static $references = array(
        'category'  => ElementType::Category,
        'globalset' => ElementType::GlobalSet,
        'global'    => ElementType::GlobalSet,
        'entry'     => ElementType::Entry,
        'asset'     => ElementType::Asset,
        'user'      => ElementType::User,
        'tag'       => ElementType::Tag,
    );

    /**
     * The content parsed after each iteration used to beak out of recursive parsing
     *
     * @var    string
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

        return sprintf('/%s(%s):([a-z0-9\@\.\-\_\/]+):?(.*?)%s/i', static::$openingTag, $references,
            static::$closingTag);
    }

    /**
     * Parses reference tags recursively
     *
     * @param string $source
     * @param array  $options
     *
     * @return    string
     */
    public function parse($source, array $options = array())
    {
        if (!$this->canBeSafelyParsed($source) || stripos($source, '{') === false) {
            return $source;
        }

        $source = preg_replace_callback(static::getPattern(), array($this, 'handleTagMatch'), $source);

        if ($this->parsedContent === $source) {
            return $source;
        }

        $this->parsedContent = $source;

        return $this->parse($source);
    }

    /**
     * Handles a matched reference tag and replaces it with actual content or the tag itself
     *
     * @param array $matches
     *
     * @return mixed|BaseElementModel
     */
    public function handleTagMatch(array $matches = array())
    {
        $matchedTag      = array_shift($matches);                        // {entry:1:title}
        $elementType     = $matches[0];                                    // entry
        $elementCriteria = $matches[1];                                    // 1
        $elementString   = isset($matches[2]) ? $matches[2] : false;        // title
        $element         = $this->getElementByReferenceTag($elementType, $elementCriteria);

        if ($element) {
            if ($elementString) {
                $elementString = '{'.$elementString.'}';

                try {
                    return craft()->templates->renderObjectTemplate($elementString, $element);
                } catch (\Exception $e) {
                    return $matchedTag;
                }
            }

            return $element;
        }

        return $matchedTag;
    }

    /**
     * Finds an element based on what type and criteria is provided
     *
     * @example
     * $elementType        = One of (category|global|entry|user|asset|tag)
     * $elementCriteria    = One of (id|username|email|section/slug)
     *
     * @param string $elementType
     * @param string $elementCriteria
     *
     * @return mixed|BaseElementModel
     */
    public function getElementByReferenceTag($elementType, $elementCriteria)
    {
        $criteria    = array('limit' => 1);
        $elementType = strtolower($elementType);

        if (!array_key_exists($elementType, static::$references)) {
            return false;
        }

        switch ($elementType) {
            case 'entry': {
                $elementCriteria = array_map('trim', explode('/', $elementCriteria));

                if (count($elementCriteria) == 1) {
                    $criteria['id'] = (int)$elementCriteria[0];
                } elseif (count($elementCriteria) == 2) {
                    $criteria['section'] = $elementCriteria[0];
                    $criteria['slug']    = $elementCriteria[1];
                }

                break;
            }
            case 'global':
            case 'globalset': {
                if (is_numeric($elementCriteria)) {
                    $criteria['id'] = (int)$elementCriteria;
                } else {
                    $criteria['handle'] = $elementCriteria;
                }

                break;
            }
            case 'user': {
                if (stripos($elementCriteria, '@')) {
                    $criteria['email'] = $elementCriteria;
                } elseif (is_numeric($elementCriteria)) {
                    $criteria['id'] = (int)$elementCriteria;
                } else {
                    $criteria['username'] = $elementCriteria;
                }

                break;
            }
            default: {
                $criteria['id'] = $elementCriteria;
            }
        }

        return craft()->elements->getCriteria(static::$references[$elementType])->first($criteria);
    }
}
