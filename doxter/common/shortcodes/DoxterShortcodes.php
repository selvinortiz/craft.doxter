<?php
namespace Craft;

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

		if ($asset && ($image = craft()->elements->getElementById($asset)))
		{
			$src = $image->getUrl($transform);

			if (empty($alt))
			{
				$alt = $image->getTitle();
			}
		}

		if (!empty($src))
		{
			$vars = array(
				'src'     => $src,
				'alt'     => $alt,
				'content' => $code->parseContent(),
				'wrapper' => $code->getParam('wrapper', 'p'),
				'class'   => $code->getParam('class', 'fluid'),
			);

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

		if (!empty($src))
		{
			if (strpos($src, '/'))
			{
				$src = array_pop(explode('/', $src));
			}

			$vars = array(
				'src'    => $src,
				'name'   => $code->name,
				'title'  => (int) $code->getParam('title', 0),
				'byline' => (int) $code->getParam('byline', 0),
				'color'  => $code->getParam('color'),
			);

			craft()->templates->includeJsResource('doxter/js/fitvids.js');
			craft()->templates->includeJs('$(".doxter-video").fitVids();');
			
			return doxter()->renderPluginTemplate('shortcodes/_video', $vars);
		}
	}
}
