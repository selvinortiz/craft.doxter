<?php
namespace Craft;

class DoxterVariable
{
	protected $plugin;

	public function __construct()
	{
		$this->plugin = craft()->plugins->getPlugin('doxter');
	}

	public function getName($real=false)
	{
		return $this->plugin->getName($real);
	}

	public function getVersion()
	{
		return $this->plugin->getVersion();
	}

	public function getUrl()
	{
		return sprintf('/%s/doxter', craft()->config->get('cpTrigger'));
	}
}
