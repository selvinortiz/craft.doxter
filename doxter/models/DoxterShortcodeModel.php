<?php
namespace Craft;

/**
 * Models the properties of a parsed shortcode
 *
 * Class DoxterShortcodeModel
 *
 * @package Craft
 *
 * @property string $name
 * @property array  $params
 * @property string $content
 *
 * @example
 * [image src="/images/image.jpg" alt="My Image"/]
 *
 * {
 *  name: "image",
 *  params: {src: "/images/image.jpg", alt: "My Image"},
 *  content: ""
 * }
 *
 * [updates]
 *  [note type="added"]Added a very cool feature[/note]
 * [/updates]
 *
 * {
 *  name: "updates"
 *  params: {},
 *  content: "[note type=\"added\"]Added a very cool feature[/note]"
 * }
 */
class DoxterShortcodeModel extends BaseModel
{
    /**
     * @return DoxterShortcodeModel
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Returns the value of an attribute if found or $default value
     *
     * @param string     $attribute
     * @param null|mixed $default
     *
     * @return null|mixed
     */
    public function get($attribute, $default = null)
    {
        return isset($this->{$attribute}) ? $this->{$attribute} : $default;
    }

    /**
     * Returns a parsed shortcode parameter value if found or $default value
     *
     * @param string     $name
     * @param null|mixed $default
     *
     * @return null|mixed
     */
    public function getParam($name, $default = null)
    {
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }

    /**
     * Parses the shortcode content after initial parsing if inner tags are found
     *
     * @return \Twig_Markup
     */
    public function parseContent()
    {
        if (!empty($this->content)) {
            if (strpos($this->content, '[') !== false || strpos($this->content, '{') !== false) {
                return DoxterShortcodeParser::instance()->parse($this->content);
            }

            return $this->content;
        }
    }

    /**
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'name'    => AttributeType::String,
            'params'  => array(AttributeType::Mixed, 'default' => array()),
            'content' => array(AttributeType::String, 'default' => ''),
        );
    }
}
