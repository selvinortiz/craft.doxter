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

	/**
	 * The doxter funtion/filter converts markdown to html
	 *
	 * - Handle empty strings safely @link https://github.com/selvinortiz/craft.doxter/issues/5
	 * - Handle parseRefs returned value @link https://github.com/selvinortiz/craft.doxter/issues/6
	 *
	 * @param	mixed	$source	The source string or object that implements __toString
	 * @param	array	$params Filter/Function arguments passed in from twig
	 * @return	mixed			The parsed string or false if not a valid source
	 */
	public function doxter($source='', array $params=array())
	{
		if (!empty($source) && (is_string($source) || method_exists($source, '__toString')))
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
