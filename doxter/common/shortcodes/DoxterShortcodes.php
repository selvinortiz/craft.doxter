<?php
namespace Craft;

/**
 * Class DoxterShortcodes
 *
 * @package Craft
 */
class DoxterShortcodes
{
    /**
     * @param DoxterShortcodeModel $code
     *
     * @return string
     */
    public function image(DoxterShortcodeModel $code)
    {
        $src       = $code->getParam('src');
        $alt       = $code->getParam('alt');
        $asset     = $code->getParam('asset');
        $transform = $code->getParam('transform', 'coverSmall');

        if ($asset && ($image = craft()->elements->getElementById($asset))) {
            /**
             * @var AssetFileModel $image
             */
            $src = $image->getUrl($transform);

            if (empty($alt)) {
                $alt = $image->getTitle();
            }
        }

        if (!empty($src)) {
            $vars = array(
                'src'     => $src,
                'alt'     => $alt,
                'content' => $code->parseContent(),
                'wrapper' => $code->getParam('wrapper', 'p'),
                'class'   => $code->getParam('class', 'fluid'),
            );

            if (craft()->templates->doesTemplateExist('_doxter/shortcodes/image')) {
                return craft()->templates->render('_doxter/shortcodes/image', $vars);
            }

            return doxter()->renderPluginTemplate('shortcodes/_image', $vars);
        }
    }

    /**
     * @param DoxterShortcodeModel $code
     *
     * @return string
     */
    public function video(DoxterShortcodeModel $code)
    {
        $src = $code->getParam('src');

        if (!empty($src)) {
            if (strpos($src, '/') !== false) {
                $src = array_pop(explode('/', $src));
            }

            $vars = array(
                'src'    => $src,
                'name'   => $code->name,
                'title'  => (int)$code->getParam('title', 0),
                'byline' => (int)$code->getParam('byline', 0),
                'color'  => $code->getParam('color'),
            );

            craft()->templates->includeJsResource('doxter/js/fitvids.js');
            craft()->templates->includeJs('$(".doxter-video").fitVids();');

            if (craft()->templates->doesTemplateExist('_doxter/shortcodes/video')) {
                return craft()->templates->render('_doxter/shortcodes/video', $vars);
            }

            return doxter()->renderPluginTemplate('shortcodes/_video', $vars);
        }
    }

    /**
     * @param DoxterShortcodeModel $code
     *
     * @return string
     */
    public function audio(DoxterShortcodeModel $code)
    {
        $src = $code->getParam('src');

        if (!empty($src)) {
            $vars = array(
                'src'   => $src,
                'size'  => $code->getParam('size', 'large'),
                'color' => $code->getParam('color', '00aabb'),
            );

            if (craft()->templates->doesTemplateExist('_doxter/shortcodes/audio')) {
                return craft()->templates->render('_doxter/shortcodes/audio', $vars);
            }

            return doxter()->renderPluginTemplate('shortcodes/_audio', $vars);
        }
    }

    /**
     * @param DoxterShortcodeModel $code
     *
     * @return string
     */
    public function updates(DoxterShortcodeModel $code)
    {
        $lines = array_filter(array_map('trim', explode(PHP_EOL, $code->content)));
        $notes = array();

        if (count($lines)) {
            foreach ($lines as $index => $line) {
                $line    = doxter()->parseMarkdownInline(preg_replace('/^([ \-\+\*\=]+)?/', '', $line));
                $type    = $this->getUpdateTypeFromLine($line);
                $notes[] = array(
                    'text' => $line,
                    'type' => $type,
                );
            }
        }

        if (craft()->templates->doesTemplateExist('_doxter/shortcodes/updates')) {
            return craft()->templates->render('_doxter/shortcodes/updates', compact('notes'));
        }

        return doxter()->renderPluginTemplate('shortcodes/_updates', compact('notes'));
    }

    /**
     * @param $line
     *
     * @return string
     */
    protected function getUpdateTypeFromLine($line)
    {
        if (is_string($line)) {
            $type = array_shift(explode(' ', trim($line)));

            switch (strtolower($type)) {
                case 'add':
                case 'adds':
                case 'added': {
                    return 'added';
                    break;
                }
                case 'fix':
                case 'fixes':
                case 'fixed': {
                    return 'fixed';
                    break;
                }
                case 'improve':
                case 'improves':
                case 'improved': {
                    return 'improved';
                    break;
                }
                case 'update':
                case 'updates':
                case 'updated': {
                    return 'updated';
                    break;
                }
                case 'remove':
                case 'removes':
                case 'removed': {
                    return 'removed';
                    break;
                }
                case 'rename':
                case 'renames':
                case 'renamed': {
                    return 'renamed';
                    break;
                }
                case 'introduce':
                case 'introduces':
                case 'introduced': {
                    return 'renamed';
                    break;
                }
                default: {
                    return false;
                }
            }
        }
    }
}
