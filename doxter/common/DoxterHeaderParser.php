<?php
namespace Craft;

/**
 * Class DoxterHeaderParser
 *
 * @package Craft
 */
class DoxterHeaderParser extends DoxterBaseParser
{
    /**
     * @var DoxterHeaderParser
     */
    protected static $instance;

    /**
     * Whether or not anchors should be added
     *
     * @var int
     */
    protected $addHeaderAnchors;

    /**
     * The header level to start output at
     *
     * @var int
     */
    protected $startingHeaderLevel;

    /**
     * Parses headers and adds anchors to them if necessary
     *
     * @param string $source  HTML source to search for headers within
     * @param array  $options Passed in parsing options
     *
     * @return string
     */
    public function parse($source, array $options = array())
    {
        $addHeaderAnchors    = null;
        $addHeaderAnchorsTo  = array('h1', 'h2', 'h3');
        $startingHeaderLevel = 1;

        extract($options);


        if ($addHeaderAnchors) {
            if (!is_array($addHeaderAnchorsTo)) {
                $addHeaderAnchorsTo = doxter()->getHeadersToParse($addHeaderAnchorsTo);
            }

            $headers = implode('|', array_map('trim', $addHeaderAnchorsTo));
        } else {
            $headers = 'h1|h2|h3|h4|h5|h6';
        }

        $this->addHeaderAnchors    = $addHeaderAnchors;
        $this->startingHeaderLevel = $startingHeaderLevel;

        $pattern = sprintf('/<(?<tag>%s)>(?<text>.*?)<\/(%s)>/i', $headers, $headers);
        $source  = preg_replace_callback($pattern, array($this, 'handleMatch'), $source);

        return $source;
    }

    /**
     * Uses the matched headers to modify level and create an anchor for them
     *
     * @param array $matches
     *
     * @return string
     */
    public function handleMatch(array $matches = array())
    {
        $tag  = $matches['tag'];
        $text = $matches['text'];

        $currentHeaderLevel = (int)substr($tag, 1, 1);

        if ($this->startingHeaderLevel) {
            $tag = sprintf('h%s', min(6, $currentHeaderLevel + ($this->startingHeaderLevel - 1)));
        }

        if ($this->addHeaderAnchors) {
            $slug  = ElementHelper::createSlug($text);
            $clean = strip_tags($text);

            return "<{$tag} id=\"{$slug}\">{$text} <a class=\"anchor\" href=\"#{$slug}\" title=\"{$clean}\">#</a></{$tag}>";
        }

        return "<{$tag}>{$text}</{$tag}>";
    }
}
