<?php
namespace Craft;

use \Twig_Extension;
use \Twig_SimpleFilter;

class DoxterTwigExtension extends Twig_Extension
{
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
	 * @param	mixed	$source	The source string or object that implements __toString
	 * @param	array	$params Filter arguments passed in from twig
	 * @return	mixed			The parsed string or false if not a valid source
	 */
	public function doxter($source='', array $params=array())
	{
		return doxter()->service->parse($source, $params);
	}

	public function getFilters()
	{
		return array(
			'doxter' => new Twig_SimpleFilter('doxter', array($this, 'doxter'))
		);
	}
}
