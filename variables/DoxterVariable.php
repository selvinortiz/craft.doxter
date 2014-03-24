<?php
namespace Craft;

class DoxterVariable
{
	public function getName($real=false)
	{
		return doxter()->plugin->getName($real);
	}

	public function getVersion()
	{
		return doxter()->plugin->getVersion();
	}

	public function getDeveloper()
	{
		return doxter()->plugin->getDeveloper();
	}

	public function getCpUrl()
	{
		return doxter()->plugin->getCpUrl();
	}

	public function getCpSettingsUrl()
	{
		return doxter()->plugin->getCpSettingsUrl();
	}
}
