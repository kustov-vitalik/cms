<?php

set_time_limit(0);
ini_set('memory_limit', "10M");

defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------
// Load the core Kohana class
require SYSPATH . 'classes/Kohana/Core' . EXT;

if (is_file(APPPATH . 'classes/Kohana' . EXT))
{
    // Application extends the core
    require APPPATH . 'classes/Kohana' . EXT;
}
else
{
    // Load empty core extension
    require SYSPATH . 'classes/Kohana' . EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Asia/Novosibirsk');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'ru_RU.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-ru');
Session::$default = 'cookie';
Cookie::$salt = '7wdjkri5j';

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
    Kohana::$environment = constant('Kohana::' . strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
    'base_url'   => '/',
    'index_file' => FALSE,
    'charset'    => 'utf-8',
    //'cache_dir' => 'APPPATH/cache',
    //'cache_life' => 60,
    'errors'     => TRUE,
    'profile'    => TRUE,
    'caching'    => FALSE,
    'expose'     => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH . 'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    'events'          => MODPATH . 'events', // Kohana events
    'auth'            => MODPATH . 'auth', // Basic authentication
    'cache'           => MODPATH . 'cache', // Caching with multiple backends
    // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
    'database-addon'  => MODPATH . 'database-addon', // Database access
    'database'        => MODPATH . 'database', // Database access
    //'image'           => MODPATH . 'image', // Image manipulation
    // 'minion'     => MODPATH.'minion',     // CLI Tasks
    'orm'             => MODPATH . 'orm', // Object Relationship Mapping
    // 'unittest'        => MODPATH . 'unittest', // Unit testing
    'userguide'       => MODPATH . 'userguide', // User guide and API documentation
    //'calendar'  => MODPATH.'calendar',  // User guide and API documentation
    //'captcha'  => MODPATH.'captcha',  // User guide and API documentation
    //'email'  => MODPATH.'email',  // User guide and API documentation
    //'email-queue'  => MODPATH.'email-queue',  // User guide and API documentation
    //'mPDF'  => MODPATH.'mPDF',  // User guide and API documentation
    'pagination'      => MODPATH . 'pagination', // User guide and API documentation
    'profilertoolbar' => MODPATH . 'profilertoolbar', // User guide and API documentation
    'ulogin'          => MODPATH . 'ulogin', // User guide and API documentation
    'zend'            => MODPATH . 'zend', // User guide and API documentation
    'search'          => MODPATH . 'search', // User guide and API documentation
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('widget', 'widget(/<controller>(/<param>))', array(
            'param' => '.+'
        ))
        ->defaults(array(
            'directory' => 'widget',
            'action'    => 'index',
        ));


Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))', array(
            'id' => '.+'
        ))
        ->defaults(array(
            'directory'  => 'admin',
            'controller' => 'pages',
            'action'     => 'index',
        ));



Route::set('default', '(<mod>(/<control>(/<act>(/<param>))))', array(
            'page' => '[0-9]+'
        ))
        ->defaults(array(
            'controller' => 'base',
            'action'     => 'index',
            'mod'        => 'home',
        ));
