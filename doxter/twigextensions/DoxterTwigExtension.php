<?php
namespace Craft;

use \Twig_Extension;
use \Twig_SimpleFilter;

/**
 * Class DoxterTwigExtension
 *
 * @package Craft
 */
class DoxterTwigExtension extends Twig_Extension
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Doxter Extension';
    }

    /**
     * The doxter filter converts markdown to html
     *
     * - Handle empty strings safely @link https://github.com/selvinortiz/craft.doxter/issues/5
     * - Handle parseRefs returned value @link https://github.com/selvinortiz/craft.doxter/issues/6
     *
     * @param string $source  The source string or object that implements __toString
     * @param array  $options Filter arguments passed in from twig
     *
     * @return mixed The parsed string or false if not a valid source
     */
    public function doxter($source = '', array $options = array())
    {
        $parsed = doxter()->parse($source, $options);

        if (is_object($source) && $source instanceof RichTextData) {
            return new RichTextData($parsed, craft()->templates->getTwig()->getCharset());
        }

        return $parsed;
    }

    public function doxterTypography($source = '')
    {
        return TemplateHelper::getRaw(typogrify($source));
    }

    /**
     * Makes the filters available to the template context
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            'doxter'           => new Twig_SimpleFilter('doxter', array($this, 'doxter')),
            'doxterTypography' => new Twig_SimpleFilter('doxterTypography', array($this, 'doxterTypography'))
        );
    }
}
