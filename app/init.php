<?php

namespace UkraineDefender\PropagandaBanhammerAnalytics;

use WeRtOG\FoxyMVC\Route;
use WeRtOG\Utils\DatabaseManager\Database;

require 'vendor/autoload.php';

$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

define('MVC_ASSETS', dirname(__DIR__) . '/assets');
define('MVC_MODELS', __DIR__ . '/models');
define('MVC_CONTROLLERS', __DIR__ . '/controllers');

define('PROJECT_ABSOLUTE', '/');
define('PROJECT_ABSOLUTE_STORAGE', PROJECT_ABSOLUTE . 'storage');
define('PROJECT_ABSOLUTE_ASSETS', PROJECT_ABSOLUTE . 'assets');

define('PROJECT_STORAGE', dirname(__DIR__) . '/storage');
define('DEVICES_DIR', PROJECT_STORAGE . '/devices');
define('REPORTPEERS_DIR', PROJECT_STORAGE . '/report/peers');

Route::ConnectFolder(MVC_MODELS);
Route::ConnectFolder(MVC_CONTROLLERS);

$ProjectModels = [
    'DeviceList' => DeviceList::FromFolder(DEVICES_DIR)
];

Route::Start(
    ProjectNamespace: __NAMESPACE__,
    ProjectPath: __DIR__,
    Models: $ProjectModels
);