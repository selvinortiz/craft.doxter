<?php
namespace Craft;

/**
 * The markdown parser
 *
 * Class DoxterCodeBlockParser
 *
 * @package Craft
 */
class DoxterMarkdownParser extends DoxterBaseParser
{
    /**
     * @var DoxterMarkdownParser
     */
    protected static $instance;

    /**
     * @var \ParsedownExtra
     */
    protected static $markdownHelper;

    /**
     * @return \ParsedownExtra
     */
    public static function getMarkdownHelper()
    {
        if (!static::$markdownHelper) {
            static::$markdownHelper = new \ParsedownExtra();
        }

        return static::$markdownHelper;
    }

    /**
     * @param string $source
     * @param array  $options
     *
     * @return string
     */
    public function parse($source, array $options = array())
    {
        return static::getMarkdownHelper()->text($source);
    }

    /**
     * @param string $source
     *
     * @return string
     */
    public function parseInline($source)
    {
        $source = static::getMarkdownHelper()->text($source);

        return preg_replace('/^[ ]*\<p\>(.*)\<\/p\>[ ]*$/', '$1', $source);
    }
}
