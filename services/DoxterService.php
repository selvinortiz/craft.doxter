<?php
namespace Craft;

use \SelvinOrtiz\Zit\IZit;
use \SelvinOrtiz\Doxter\Exception\InvalidDependencyContainerException;

class DoxterService extends BaseApplicationComponent
{
	public function parse($source, array $params=array())
	{
		$pluginSettings	= doxter()->plugin->getSettings()->getAttributes();
		$combinedParams	= array_merge($pluginSettings, $params);

		return $this->safeOutput(doxter()->doxter->parse($source, $combinedParams));
	}

	public function getBoolFromLightSwitch($value)
	{
		if (is_bool($value))
		{
			return $value;
		}

		switch (strtolower($value))
		{
			case '1':
			case 'y':
			case 'on':
			case 'yes':
				return true;
			break;
			default:
				return false;
			break;
		}
	}

	public function getEnvOption($option=null, $default=null)
	{
		$env	= craft()->config->get('doxterSettings');
		$opts 	= array();

		// Settings not available
		if (is_null($env))
		{
			return $default;
		}

		// Option not provided
		if (is_null($option))
		{
			return $env;
		}

		if (is_string($option))
		{
			$opts = array_map('trim', explode('.', $option));
		}

		if (count($opts))
		{
			foreach ($opts as $opt)
			{
				if (array_key_exists($opt, $env))
				{
					$env = $env[$opt]; continue;
				}

				return $default;
			}
		}

		return $env;
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
