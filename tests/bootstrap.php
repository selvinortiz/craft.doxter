<?php

defined('CRAFT_BASE_PATH')         || define('CRAFT_BASE_PATH',			'/var/www/selvinortiz.dev/craft/');
defined('CRAFT_APP_PATH')          || define('CRAFT_APP_PATH',          CRAFT_BASE_PATH.'app/');
defined('CRAFT_CONFIG_PATH')       || define('CRAFT_CONFIG_PATH',       CRAFT_BASE_PATH.'config/');
defined('CRAFT_PLUGINS_PATH')      || define('CRAFT_PLUGINS_PATH',      CRAFT_BASE_PATH.'plugins/');
defined('CRAFT_STORAGE_PATH')      || define('CRAFT_STORAGE_PATH',      CRAFT_BASE_PATH.'storage/');
defined('CRAFT_TEMPLATES_PATH')    || define('CRAFT_TEMPLATES_PATH',    CRAFT_BASE_PATH.'templates/');
defined('CRAFT_TRANSLATIONS_PATH') || define('CRAFT_TRANSLATIONS_PATH', CRAFT_BASE_PATH.'translations/');
defined('CRAFT_ENVIRONMENT')       || define('CRAFT_ENVIRONMENT',       'selvinortiz.dev');

define('YII_ENABLE_EXCEPTION_HANDLER', false);
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);

$_SERVER['DOCUMENT_ROOT']   = '/some/path/to/craft.dev';
$_SERVER['HTTP_HOST']       = 'craft.dev';
$_SERVER['HTTPS']           = 'off';
$_SERVER['PHP_SELF']        = '/index.php';
$_SERVER['REQUEST_URI']     = '/index.php';
$_SERVER['SERVER_PORT']     = 80;
$_SERVER['SCRIPT_FILENAME'] = '/some/path/to/craft.dev/index.php';
$_SERVER['SCRIPT_NAME']     = '/index.php';

function craft_createFolder($path)
{
	if (!is_dir($path))
	{
		$oldumask = umask(0);

		if (!mkdir($path, 0755, true))
		{
			exit('Tried to create a folder at '.$path.', but could not.');
		}

		chmod($path, 0755);
		umask($oldumask);
	}
}

function craft_ensureFolderIsReadable($path, $writableToo = false)
{
	$realPath = realpath($path);

	if ($realPath === false || !is_dir($realPath) || !@file_exists($realPath.'/.'))
	{
		exit (($realPath !== false ? $realPath : $path).' doesn\'t exist or isn\'t writable by PHP. Please fix that.');
	}

	if ($writableToo)
	{
		if (!is_writable($realPath))
		{
			exit ($realPath.' isn\'t writable by PHP. Please fix that.');
		}
	}
}

craft_ensureFolderIsReadable(CRAFT_CONFIG_PATH);
craft_ensureFolderIsReadable(CRAFT_STORAGE_PATH, true);

craft_createFolder(CRAFT_STORAGE_PATH.'runtime/');
craft_ensureFolderIsReadable(CRAFT_STORAGE_PATH.'runtime/', true);

$yiit   = CRAFT_APP_PATH.'framework/yiit.php';
$config = CRAFT_APP_PATH.'etc/config/test.php';

require_once $yiit;

require CRAFT_APP_PATH.'vendor/autoload.php';

require_once CRAFT_APP_PATH.'Craft.php';
require_once CRAFT_APP_PATH.'etc/web/WebApp.php';
require_once CRAFT_APP_PATH.'tests/TestApplication.php';

new Craft\TestApplication($config);

require_once 'DoxterBase.php';
