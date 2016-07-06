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
        $this->autoload();

        $this->config = m::mock('Craft\ConfigService');

        $this->config->shouldReceive('usePathInfo')->andReturn(true)->byDefault();
        $this->config->shouldReceive('getIsInitialized')->andReturn(true)->byDefault();
        $this->config->shouldReceive('omitScriptNameInUrls')->andReturn(true)->byDefault();

        $this->config->shouldReceive('get')->with('defaultFolderPermissions')->andReturn(0777)->byDefault();
        $this->config->shouldReceive('get')->with('user', 'db')->andReturn('root')->byDefault();
        $this->config->shouldReceive('get')->with('password', 'db')->andReturn('secret')->byDefault();
        $this->config->shouldReceive('get')->with('database', 'db')->andReturn('selvinortizdev')->byDefault();
        $this->config->shouldReceive('get')->with('devMode')->andReturn(false)->byDefault();
        $this->config->shouldReceive('get')->with('cpTrigger')->andReturn('admin')->byDefault();
        $this->config->shouldReceive('get')->with('baseCpUrl')->andReturn('http://selvinortiz.dev/')->byDefault();
        $this->config->shouldReceive('get')->with('pageTrigger')->andReturn('p')->byDefault();
        $this->config->shouldReceive('get')->with('actionTrigger')->andReturn('action')->byDefault();
        $this->config->shouldReceive('get')->with('usePathInfo')->andReturn(true)->byDefault();
        $this->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false)->byDefault();
        $this->config->shouldReceive('get')->with('tokenParam')->andReturn(null)->byDefault();

        $this->config->shouldReceive('getLocalized')->with('loginPath')->andReturn('login')->byDefault();
        $this->config->shouldReceive('getLocalized')->with('logoutPath')->andReturn('logout')->byDefault();
        $this->config->shouldReceive('getLocalized')->with('setPasswordPath')->andReturn('setpassword')->byDefault();
        $this->config->shouldReceive('getLocalized')->with('siteUrl')->andReturn('http://selvinortiz.dev')->byDefault();

        $this->config->shouldReceive('getCpLoginPath')->andReturn('login')->byDefault();
        $this->config->shouldReceive('getCpLogoutPath')->andReturn('logout')->byDefault();
        $this->config->shouldReceive('getCpSetPasswordPath')->andReturn('setpassword')->byDefault();
        $this->config->shouldReceive('getResourceTrigger')->andReturn('resource')->byDefault();

        $this->config->shouldReceive('get')->with('doxterSettings')->andReturn(null)->byDefault();
        $this->config->shouldReceive('get')->with('slugWordSeparator')->andReturn('-')->byDefault();
        $this->config->shouldReceive('get')->with('allowUppercaseInSlug')->andReturn(false)->byDefault();
        $this->config->shouldReceive('get')->with('addTrailingSlashesToUrls')->andReturn(true)->byDefault();
        $this->config->shouldReceive('get')->with('timezone')->andReturn(new \DateTimeZone('UTC'))->byDefault();

        $this->setComponent(craft(), 'config', $this->config);

        $plugin        = new DoxterPlugin;
        $pluginService = m::mock('Craft\PluginsService[getPlugin]');

        $plugin->init();
        $pluginService->shouldReceive('getPlugin')->with('doxter')->andReturn($plugin)->byDefault();

        $this->setComponent(craft(), 'plugins', $pluginService);
        $this->setComponent(craft(), 'doxter', new DoxterService);

        $referenceTagParser = m::mock('Craft\DoxterReferenceTagParser[getElement]');

        $referenceTagParser->shouldReceive('getElement')->withAnyArgs()->andReturn(null)->byDefault();
    }

    public function tearDown()
    {
        m::close();
    }

    protected function autoload()
    {
        $map = array(
            '\\Craft\\DoxterPlugin'             => __DIR__.'/../doxter/DoxterPlugin.php',
            '\\Craft\\DoxterModel'              => __DIR__.'/../doxter/models/DoxterModel.php',
            '\\Craft\\DoxterService'            => __DIR__.'/../doxter/services/DoxterService.php',
            '\\Craft\\DoxterVariable'           => __DIR__.'/../doxter/variables/DoxterVariable.php',
            '\\Craft\\DoxterFieldType'          => __DIR__.'/../doxter/fieldtypes/DoxterFieldType.php',
            '\\Craft\\DoxterTwigExtension'      => __DIR__.'/../doxter/twigextensions/DoxterTwigExtension.php',
            '\\Craft\\DoxterBaseParser'         => __DIR__.'/../doxter/common/DoxterBaseParser.php',
            '\\Craft\\DoxterMarkdownParser'     => __DIR__.'/../doxter/common/DoxterMarkdownParser.php',
            '\\Craft\\DoxterHeaderParser'       => __DIR__.'/../doxter/common/DoxterHeaderParser.php',
            '\\Craft\\DoxterCodeBlockParser'    => __DIR__.'/../doxter/common/DoxterCodeBlockParser.php',
            '\\Craft\\DoxterReferenceTagParser' => __DIR__.'/../doxter/common/DoxterReferenceTagParser.php',
            '\\Craft\\DoxterShortCodeParser'    => __DIR__.'/../doxter/common/DoxterShortCodeParser.php',
        );

        foreach ($map as $classPath => $filePath) {
            if (!class_exists($classPath, false)) {
                require_once $filePath;
            }
        }
    }
}
