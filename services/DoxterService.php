<?php
namespace Craft;

use \SelvinOrtiz\Doxter;

class DoxterService extends BaseApplicationComponent
{
	public function transform($source, array $params=array())
	{
		$doxter = new Doxter($params);

		return $this->safeOutput($doxter->setSource($source)->parse()->compile());
	}

	public function getBoolFromLightSwitch($value)
	{
		switch ($value)
		{
			case 'on':
			case 'yes':
				return true;
			break;
			default:
				return false;
			break;
		}
	}

	public function safeOutput($content, $charset=null)
	{
		if (is_null($charset))
		{
			$charset = craft()->templates->getTwig()->getCharset();
		}

		return new \Twig_Markup($content, (string) $charset);
	}
}
