<?php
namespace Craft;

class DoxterVariable
{
	protected $doxter;

	public function getPlugin()
	{
		if ($this->doxter === null)
		{
			$this->doxter = craft()->plugins->getPlugin('doxter');
		}

		return $this->doxter;
	}

	public function getName($real=false)
	{
		return $this->getPlugin()->getName($real);
	}

	public function getVersion()
	{
		return $this->getPlugin()->getVersion();
	}

	public function getDeveloper()
	{
		return $this->getPlugin()->getDeveloper();
	}

	public function getCpUrl()
	{
		return UrlHelper::getCpUrl('doxter');
	}

	public function getCpSettingsUrl()
	{
		return UrlHelper::getCpUrl('settings/plugins/doxter');
	}
}
