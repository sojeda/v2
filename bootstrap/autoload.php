<?php

use Slim\Slim as App;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

define('MICROVOZ_START', microtime(true));
define('BASE_DIR', dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require BASE_DIR . '/vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require BASE_DIR.'/app/config/database.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

if (file_exists($compiled = BASE_DIR.'/compiled.php'))
{
	require $compiled;
}

/*
|--------------------------------------------------------------------------
| Setup Patchwork UTF-8 Handling
|--------------------------------------------------------------------------
|
| The Patchwork library provides solid handling of UTF-8 strings as well
| as provides replacements for all mb_* and iconv type functions that
| are not available by default in PHP. We'll setup this stuff here.
|
*/

Patchwork\Utf8\Bootup::initMbstring();

$app = new App([
    'view' => new Twig(),
    'templates.path' => BASE_DIR . '/views',
]);

require_once BASE_DIR . '/app/routes.php';

$view = $app->view();

$view->parserOptions = [
    'debug' => false
];

$view->parserExtensions = [
    new TwigExtension
];




