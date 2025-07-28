<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode check
$maintenance = __DIR__ . '/../storage/framework/maintenance.php';
if (file_exists($maintenance)) {
    require $maintenance;
}

// Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the incoming request and send the response
$response = $app->handleRequest(Request::capture())->send();

$app->terminate($request = Request::capture(), $response);
