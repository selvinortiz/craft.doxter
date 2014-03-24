<?php
namespace Craft;

use Mockery as m;
use SelvinOrtiz\Doxter\Di;

class DoxterBaseTest extends BaseTest
{
	/**
	 * UNIT TESTS
	 * ----------
	 */
	public function testDependencyInjectionContainer()
	{
		$this->assertTrue(doxter() instanceof Di);
	}

	/**
	 * ENVIRONMENT
	 * -----------
	 */
	public function setUp()
	{
		$config = m::mock('Craft\ConfigService');
		$config->shouldReceive('usePathInfo')->andReturn(true)->byDefault();
		$config->shouldReceive('getIsInitialized')->andReturn(true)->byDefault();
		$config->shouldReceive('omitScriptNameInUrls')->andReturn(true)->byDefault();

		$config->shouldReceive('get')->with('devMode')->andReturn(false)->byDefault();
		$config->shouldReceive('get')->with('cpTrigger')->andReturn('admin')->byDefault();
		$config->shouldReceive('get')->with('pageTrigger')->andReturn('p')->byDefault();
		$config->shouldReceive('get')->with('actionTrigger')->andReturn('action')->byDefault();
		$config->shouldReceive('get')->with('usePathInfo')->andReturn(true)->byDefault();
		$config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false)->byDefault();

		$config->shouldReceive('getLocalized')->with('loginPath')->andReturn('login')->byDefault();
		$config->shouldReceive('getLocalized')->with('logoutPath')->andReturn('logout')->byDefault();
		$config->shouldReceive('getLocalized')->with('setPasswordPath')->andReturn('setpassword')->byDefault();

		$config->shouldReceive('getCpLoginPath')->andReturn('login')->byDefault();
		$config->shouldReceive('getCpLogoutPath')->andReturn('logout')->byDefault();
		$config->shouldReceive('getCpSetPasswordPath')->andReturn('setpassword')->byDefault();
		$config->shouldReceive('getResourceTrigger')->andReturn('resource')->byDefault();

		$this->setComponent(craft(), 'config', $config);

		$this->autoload();

		doxter()->stash('config', $config);
		doxter()->stash('plugin', new DoxterPlugin);
		doxter()->stash('service', new DoxterService);
		doxter()->stash('variable', new DoxterVariable);
		doxter()->stash('extension', new DoxterTwigExtension);
		doxter()->stash('fieldtype', new DoxterFieldType);

		doxter()->init();
	}

	public function tearDown()
	{
		m::close();
	}

	/**
	 * HELPER METHODS
	 * -----------------
	 */
	protected function autoload()
	{
		require_once '../library/vendor/autoload.php';

		$map = array(
			'\\Craft\\DoxterPlugin'			=> '../DoxterPlugin.php',
			'\\Craft\\DoxterService'		=> '../services/DoxterService.php',
			'\\Craft\\DoxterVariable'		=> '../variables/DoxterVariable.php',
			'\\Craft\\DoxterFieldType'		=> '../fieldtypes/DoxterFieldType.php',
			'\\Craft\\DoxterTwigExtension'	=> '../twigextensions/DoxterTwigExtension.php',
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

if (!function_exists('\\Craft\\doxter'))
{	
	function doxter()
	{
		return \SelvinOrtiz\Doxter\Di::getInstance();
	}
}
