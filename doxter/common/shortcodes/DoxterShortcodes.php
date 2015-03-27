<?php
namespace Craft;

class DoxterShortcodes
{
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
				'class'   => $code->getParam('class', 'fluid'),
			);

			return doxter()->renderPluginTemplate('shortcodes/_image', $vars);
		}
	}
}
