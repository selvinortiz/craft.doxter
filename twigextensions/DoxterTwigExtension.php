<?php
namespace Craft;

use \Twig_Extension;
use \Twig_SimpleFilter;

class DoxterTwigExtension extends Twig_Extension
{
	public function getName()
	{
		return 'Doxter';
	}

	public function doxter($source='', array $params=array())
	{
		// Only transform non empty strings @see issue #5
		if (is_string($source) && !empty($source))
		{
			return craft()->doxter->transform($source, $params);
		}

		return false;
	}

	public function getFilters()
	{
		return array(
			'doxter' => new Twig_SimpleFilter('doxter', array($this, 'doxter'), array('is_safe', true))
		);
	}

	public function getFunctions()
	{
		return array(
			'doxter' => new Twig_SimpleFilter('doxter', array($this, 'doxter'), array('is_safe', true))
		);
	}
}
