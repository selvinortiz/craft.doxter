<?php
namespace Craft;

/**
 * The base parser that all other parsers must extend
 *
 * Class DoxterBaseParser
 *
 * @package Craft
 */
abstract class DoxterBaseParser
{
    /**
     * @var object The parser instance which should be defined in each extending class
     */
    protected static $instance;

    /**
     * Returns an instance of the class in called static context
     *
     * @return DoxterMarkdownParser|DoxterReferenceTagParser|DoxterShortcodeParser|DoxterCodeBlockParser|DoxterHeaderParser
     */
    public static function instance()
    {
        if (static::$instance === null) {
            $name = get_called_class();

            static::$instance = new $name;
        }

        return static::$instance;
    }

    /**
     * Reports whether the source string can be safely parsed
     *
     * @param string $source
     *
     * @return bool
     */
    public function canBeSafelyParsed($source)
    {
        if (empty($source)) {
            return false;
        }

        return (is_string($source) || is_callable(array($source, '__toString')));
    }

    /**
     * Must be implemented by all extending parsers
     *
     * @param string $source
     * @param array  $options
     *
     * @return mixed
     */
    abstract public function parse($source, array $options = array());
}
