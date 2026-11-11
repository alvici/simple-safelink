<?php

/**
 * Simple Safelink PHP
 */

define('FLIGHT_START', microtime(true));
define('BASEPATH', __DIR__);
define('SYSTEMPATH', __DIR__.'/system');
define('VIEWPATH', __DIR__.'/app/Views');

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/
date_default_timezone_set('Asia/Jakarta');
require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require __DIR__.'/bootstrap/app.php';

require __DIR__ . '/routes/web.php';
require __DIR__ . '/system/Helpers/BaseHelper.php';
require __DIR__ . '/config/app.php';

$app->start();