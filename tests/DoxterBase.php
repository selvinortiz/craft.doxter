<?php
namespace Craft;

use Mockery as m;

class DoxterBase extends BaseTest
{
	/**
	 * @var \Mockery\MockInterface
	 */
	protected $config;

	/**
	 * ENVIRONMENT
	 * -----------
	 */
	public function setUp()
	{
		$this->config = m::mock('Craft\ConfigService');

		$this->config->shouldReceive('usePathInfo')->andReturn(true)->byDefault();
		$this->config->shouldReceive('getIsInitialized')->andReturn(true)->byDefault();
		$this->config->shouldReceive('omitScriptNameInUrls')->andReturn(true)->byDefault();

		$this->config->shouldReceive('get')->with('devMode')->andReturn(false)->byDefault();
		$this->config->shouldReceive('get')->with('cpTrigger')->andReturn('admin')->byDefault();
		$this->config->shouldReceive('get')->with('pageTrigger')->andReturn('p')->byDefault();
		$this->config->shouldReceive('get')->with('actionTrigger')->andReturn('action')->byDefault();
		$this->config->shouldReceive('get')->with('usePathInfo')->andReturn(true)->byDefault();
		$this->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false)->byDefault();

		$this->config->shouldReceive('getLocalized')->with('loginPath')->andReturn('login')->byDefault();
		$this->config->shouldReceive('getLocalized')->with('logoutPath')->andReturn('logout')->byDefault();
		$this->config->shouldReceive('getLocalized')->with('setPasswordPath')->andReturn('setpassword')->byDefault();

		$this->config->shouldReceive('getCpLoginPath')->andReturn('login')->byDefault();
		$this->config->shouldReceive('getCpLogoutPath')->andReturn('logout')->byDefault();
		$this->config->shouldReceive('getCpSetPasswordPath')->andReturn('setpassword')->byDefault();
		$this->config->shouldReceive('getResourceTrigger')->andReturn('resource')->byDefault();


		$this->config->shouldReceive('get')->with('doxterSettings')->andReturn(null);
		$this->config->shouldReceive('get')->with('slugWordSeparator')->andReturn('-');

		$this->setComponent(craft(), 'config', $this->config);

		$this->autoload();

		$referenceTagParser = m::mock('Craft\DoxterReferenceTagParser[getElement]');
		$referenceTagParser->shouldReceive('getElement')->withAnyArgs()->andReturn(null);
	}

	public function tearDown()
	{
		m::close();
	}

	protected function reloadConfig()
	{
		$this->config->shouldReceive('usePathInfo')->andReturn(true);
		$this->config->shouldReceive('getIsInitialized')->andReturn(true);
		$this->config->shouldReceive('omitScriptNameInUrls')->andReturn(true);

		$this->config->shouldReceive('get')->with('devMode')->andReturn(false);
		$this->config->shouldReceive('get')->with('cpTrigger')->andReturn('admin');
		$this->config->shouldReceive('get')->with('pageTrigger')->andReturn('p');
		$this->config->shouldReceive('get')->with('actionTrigger')->andReturn('action');
		$this->config->shouldReceive('get')->with('usePathInfo')->andReturn(true);
		$this->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false);

		$this->config->shouldReceive('getLocalized')->with('loginPath')->andReturn('login');
		$this->config->shouldReceive('getLocalized')->with('logoutPath')->andReturn('logout');
		$this->config->shouldReceive('getLocalized')->with('setPasswordPath')->andReturn('setpassword');

		$this->config->shouldReceive('getCpLoginPath')->andReturn('login');
		$this->config->shouldReceive('getCpLogoutPath')->andReturn('logout');
		$this->config->shouldReceive('getCpSetPasswordPath')->andReturn('setpassword');
		$this->config->shouldReceive('getResourceTrigger')->andReturn('resource');

		$this->config->shouldReceive('get')->with('doxterSettings')->andReturn(null);
		$this->config->shouldReceive('get')->with('slugWordSeparator')->andReturn('-');
		$this->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false);

		$this->config->shouldReceive('get')->with('user', 'db')->andReturn('root');
		$this->config->shouldReceive('get')->with('password', 'db')->andReturn('secret');
		$this->config->shouldReceive('get')->with('charset', 'db')->andReturn('utf8');
		$this->config->shouldReceive('get')->with('tablePrefix', 'db')->andReturn('craft');
		$this->config->shouldReceive('get')->with('unixSocket', 'db')->andReturn(false);
	}

	protected function autoload()
	{
		$map = array(
			'\\Craft\\DoxterPlugin'				=> '../DoxterPlugin.php',
			'\\Craft\\DoxterService'			=> '../services/DoxterService.php',
			'\\Craft\\DoxterVariable'			=> '../variables/DoxterVariable.php',
			'\\Craft\\DoxterFieldType'			=> '../fieldtypes/DoxterFieldType.php',
			'\\Craft\\DoxterTwigExtension'		=> '../twigextensions/DoxterTwigExtension.php',
			'\\Craft\\DoxterBaseParser'			=> '../common/DoxterBaseParser.php',
			'\\Craft\\DoxterHeaderParser'		=> '../common/DoxterHeaderParser.php',
			'\\Craft\\DoxterCodeBlockParser'	=> '../common/DoxterCodeBlockParser.php',
			'\\Craft\\DoxterReferenceTagParser'	=> '../common/DoxterReferenceTagParser.php',
		);

		foreach ($map as $classPath => $filePath)
		{
			if (!class_exists($classPath, false))
			{
				require_once $filePath;
			}
		}
	}
}
