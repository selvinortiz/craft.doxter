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
		$this->assertTrue(doxter() instanceof \SelvinOrtiz\Doxter\Doxter);
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


		$config->shouldReceive('get')->with('doxterSettings')->andReturn(null);
		$config->shouldReceive('get')->with('slugWordSeparator')->andReturn('-');

		$this->setComponent(craft(), 'config', $config);

		$this->autoload();

		doxter()->stash('config', $config);
		doxter()->stash('plugin', new DoxterPlugin);
		doxter()->stash('service', new DoxterService);
		doxter()->stash('variable', new DoxterVariable);
		doxter()->stash('extension', new DoxterTwigExtension);
		doxter()->stash('fieldtype', new DoxterFieldType);
		
		$referenceTagParser = m::mock('SelvinOrtiz\Doxter\ReferenceTagParser[getElement]');
		$referenceTagParser->shouldReceive('getElement')->withAnyArgs()->andReturn(null);

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

	protected function reloadConfig()
	{
		doxter()->config->shouldReceive('usePathInfo')->andReturn(true);
		doxter()->config->shouldReceive('getIsInitialized')->andReturn(true);
		doxter()->config->shouldReceive('omitScriptNameInUrls')->andReturn(true);

		doxter()->config->shouldReceive('get')->with('devMode')->andReturn(false);
		doxter()->config->shouldReceive('get')->with('cpTrigger')->andReturn('admin');
		doxter()->config->shouldReceive('get')->with('pageTrigger')->andReturn('p');
		doxter()->config->shouldReceive('get')->with('actionTrigger')->andReturn('action');
		doxter()->config->shouldReceive('get')->with('usePathInfo')->andReturn(true);
		doxter()->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false);

		doxter()->config->shouldReceive('getLocalized')->with('loginPath')->andReturn('login');
		doxter()->config->shouldReceive('getLocalized')->with('logoutPath')->andReturn('logout');
		doxter()->config->shouldReceive('getLocalized')->with('setPasswordPath')->andReturn('setpassword');

		doxter()->config->shouldReceive('getCpLoginPath')->andReturn('login');
		doxter()->config->shouldReceive('getCpLogoutPath')->andReturn('logout');
		doxter()->config->shouldReceive('getCpSetPasswordPath')->andReturn('setpassword');
		doxter()->config->shouldReceive('getResourceTrigger')->andReturn('resource');

		doxter()->config->shouldReceive('get')->with('doxterSettings')->andReturn(null);
		doxter()->config->shouldReceive('get')->with('slugWordSeparator')->andReturn('-');
		doxter()->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false);

		doxter()->config->shouldReceive('get')->with('user', 'db')->andReturn('root');
		doxter()->config->shouldReceive('get')->with('password', 'db')->andReturn('secret');
		doxter()->config->shouldReceive('get')->with('charset', 'db')->andReturn('utf8');
		doxter()->config->shouldReceive('get')->with('tablePrefix', 'db')->andReturn('craft');
		doxter()->config->shouldReceive('get')->with('unixSocket', 'db')->andReturn(false);
	}

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
		return \SelvinOrtiz\Doxter\Doxter::getInstance();
	}
}
