<?php

use App\SRC\FW\Router;

use App\Controllers\GetFileController;
use App\Controllers\WebController;
use App\SRC\FW\Auth;
use App\SRC\FW\ErrorHandler;

new ErrorHandler();

Auth::check();

$routes = [
    ['ExportDisposableKeys', GetFileController::class],
    ['ExportHistory', GetFileController::class],
    ['getPage', WebController::class],
];

$router = new Router($routes);
// require './static/index.html';