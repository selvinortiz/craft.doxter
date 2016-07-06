<?php
date_default_timezone_set('UTC');

/**
 * Defines path and environment constants
 */
define('SITE_BASE_PATH', '/Users/selvinortiz/dev/www/craft.dev/');
define('CRAFT_BASE_PATH', SITE_BASE_PATH.'craft/');
define('CRAFT_APP_PATH', CRAFT_BASE_PATH.'app/');
define('CRAFT_CONFIG_PATH', CRAFT_BASE_PATH.'config/');
define('CRAFT_PLUGINS_PATH', CRAFT_BASE_PATH.'plugins/');
define('CRAFT_STORAGE_PATH', CRAFT_BASE_PATH.'storage/');
define('CRAFT_TEMPLATES_PATH', CRAFT_BASE_PATH.'templates/');
define('CRAFT_TRANSLATIONS_PATH', CRAFT_BASE_PATH.'translations/');
define('CRAFT_ENVIRONMENT', 'craft.dev');

/**
 * Defines YII error handling constants
 */
define('YII_ENABLE_EXCEPTION_HANDLER', false);
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);

/**
 * Defines server variables to use at runtime
 */
$_SERVER['DOCUMENT_ROOT']   = SITE_BASE_PATH.'public/';
$_SERVER['HTTP_HOST']       = 'craft.dev';
$_SERVER['HTTPS']           = 'off';
$_SERVER['PHP_SELF']        = '/index.php';
$_SERVER['REQUEST_URI']     = '/index.php';
$_SERVER['SERVER_PORT']     = 80;
$_SERVER['SCRIPT_FILENAME'] = SITE_BASE_PATH.'index.php';
$_SERVER['SCRIPT_NAME']     = '/index.php';

/**
 * @param string $path
 */
function craft_createFolder($path)
{
    if (!is_dir($path)) {
        $oldumask = umask(0);

        if (!mkdir($path, 0755, true)) {
            exit('Tried to create a folder at '.$path.', but could not.');
        }

        chmod($path, 0755);
        umask($oldumask);
    }
}

/**
 * @param string $path
 * @param bool   $writableToo
 */
function craft_ensureFolderIsReadable($path, $writableToo = false)
{
    $realPath = realpath($path);

    if ($realPath === false || !is_dir($realPath) || !@file_exists($realPath.'/.')) {
        exit (($realPath !== false ? $realPath : $path).' doesn\'t exist or isn\'t writable by PHP. Please fix that.');
    }

    if ($writableToo) {
        if (!is_writable($realPath)) {
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
require_once CRAFT_APP_PATH.'vendor/autoload.php';

require_once CRAFT_APP_PATH.'Craft.php';
require_once CRAFT_APP_PATH.'etc/web/WebApp.php';
require_once CRAFT_APP_PATH.'tests/TestApplication.php';

new Craft\TestApplication($config);

require_once __DIR__.'/../vendor/autoload.php';
/**
 * Imports the abstract test case so that all other tests can extend it
 */
require_once __DIR__.'/DoxterBase.php';
