<?php
namespace Craft;

/**
 * Doxter @v1.3.0
 *
 * Documentation friendly markdown for Craft
 *
 * @author         Selvin Ortiz - https://selv.in
 * @package        Craft
 * @copyright      2015 Selvin Ortiz
 * @license        MIT Copyright (c) 2015 Selvin Ortiz
 */

class DoxterPlugin extends BasePlugin
{
    /**
     * Loads dependencies and registers default shortcodes
     *
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        Craft::import('plugins.doxter.common.DoxterBaseParser');
        Craft::import('plugins.doxter.common.DoxterMarkdownParser');
        Craft::import('plugins.doxter.common.DoxterHeaderParser');
        Craft::import('plugins.doxter.common.DoxterCodeBlockParser');
        Craft::import('plugins.doxter.common.DoxterShortcodeParser');
        Craft::import('plugins.doxter.common.DoxterReferenceTagParser');
        Craft::import('plugins.doxter.common.shortcodes.DoxterShortcodes');
        Craft::import('plugins.doxter.twigextensions.DoxterTwigExtension');
        Craft::import('plugins.doxter.models.DoxterShortcodeModel');

        require_once(dirname(__FILE__).'/common/parsedown/Parsedown.php');
        require_once(dirname(__FILE__).'/common/parsedown/ParsedownExtra.php');
        require_once(dirname(__FILE__).'/common/parsedown/Typography.php');

        // Registers default shortcodes on the fly before parsing
        craft()->on('doxter.beforeShortcodeParsing', function () {
            $shortcodes = array(
                'image'         => 'Craft\\DoxterShortcodes@image',
                'audio'         => 'Craft\\DoxterShortcodes@audio',
                'updates'       => 'Craft\\DoxterShortcodes@updates',
                'vimeo:youtube' => 'Craft\\DoxterShortcodes@video',
            );

            doxter()->registerShortcodes($shortcodes);
        });
    }

    /**
     * Returns the plugin name or the plugin alias assigned by the end user
     *
     * @param bool $real Whether the real name should be returned
     *
     * @return string
     */
    public function getName($real = false)
    {
        $alias = $this->getSettings()->getAttribute('pluginAlias');

        return ($real || empty($alias)) ? 'Doxter' : $alias;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.3.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Selvin Ortiz';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://selv.in';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://github.com/selvinortiz/craft.doxter/blob/master/releases.json';
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/selvinortiz/craft.doxter';
    }

    /**
     * @return string
     */
    public function getPluginUrl()
    {
        return 'https://github.com/selvinortiz/craft.doxter';
    }

    /**
     * Whether a control panel tab should be display for Doxter
     *
     * @return bool
     */
    public function hasCpSection()
    {
        return $this->getSettings()->getAttribute('enableCpTab');
    }

    /**
     * Returns a rendered view for plugin settings
     *
     * @return string
     */
    public function getSettingsHtml()
    {
        craft()->templates->includeCssResource('doxter/css/doxter.css');
        craft()->templates->includeJsResource('doxter/js/doxter.js');
        craft()->templates->includeJs('new Craft.Doxter();');

        return craft()->templates->render(
            'doxter/settings',
            array(
                'settings' => $this->getSettings(),
            )
        );
    }

    /**
     * @return array
     */
    public function defineSettings()
    {
        return array(
            'codeBlockSnippet'    => array(AttributeType::String, 'default' => $this->getCodeBlockSnippet()),
            'addHeaderAnchors'    => array(AttributeType::Bool, 'default' => true),
            'addHeaderAnchorsTo'  => array(AttributeType::Mixed, 'default' => array('h1', 'h2', 'h3')),
            'addTypographyStyles' => array(AttributeType::Bool, 'default' => false),
            'startingHeaderLevel' => array(AttributeType::Number, 'default' => 1),
            'parseReferenceTags'  => array(AttributeType::Bool, 'default' => true),
            'parseShortcodes'     => array(AttributeType::Bool, 'default' => true),
            'enableCpTab'         => array(AttributeType::Bool, 'default' => false),
            'pluginAlias'         => array(AttributeType::String, 'default' => 'Doxter')
        );
    }

    /**
     * @param array $settings
     *
     * @return array
     */
    public function prepSettings($settings = array())
    {
        $settings['addHeaderAnchorsTo'] = doxter()->getHeadersToParse($settings['addHeaderAnchorsTo']);

        return $settings;
    }

    /**
     * Returns the default code block snippet to use
     *
     * @access protected
     * @return string
     */
    public function getCodeBlockSnippet()
    {
        return '<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>';
    }

    /**
     * @throws \Exception
     * @return DoxterTwigExtension
     */
    public function addTwigExtension()
    {
        return new DoxterTwigExtension();
    }
}

/**
 * Enables us to have a single point of access to our service layer and proper hinting
 *
 * @return DoxterService
 */
function doxter()
{
    return Craft::app()->getComponent('doxter');
}
