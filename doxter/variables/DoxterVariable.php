<?php
namespace Craft;

/**
 * Class DoxterVariable
 *
 * @package Craft
 */
class DoxterVariable
{
    /**
     * @var DoxterPlugin
     */
    protected $doxter;

    /**
     * @return DoxterPlugin|null
     */
    public function getPlugin()
    {
        if ($this->doxter === null) {
            $this->doxter = craft()->plugins->getPlugin('doxter');
        }

        return $this->doxter;
    }

    public function getName($real = false)
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

    public function getPluginUrl()
    {
        return $this->getPlugin()->getPluginUrl();
    }

    public function getDeveloperUrl()
    {
        return $this->getPlugin()->getDeveloperUrl();
    }
}
