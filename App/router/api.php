<?php

use App\SRC\FW\Router;

use App\Controllers\ServiceComandController;
use App\Controllers\LoginController;
use App\Controllers\SafetyController;
use App\Controllers\PayOutController;
use App\Controllers\UserController;
use App\Controllers\VirtualActivesController;
use App\Controllers\HistoryController;
use App\SRC\FW\Auth;
use App\SRC\FW\ErrorHandler;

new ErrorHandler();

Auth::check();

$routes = [
    ['getOperatorsListMenu', PayOutController::class],
    ['SaveCatalogTemplate', ServiceComandController::class],
    ['CreateTransferTemplate', ServiceComandController::class],
    ['CancelPayment', HistoryController::class],
    ['GetParamsFinoperationLight', HistoryController::class],
    ['GetFinoperationLight', HistoryController::class],
    ['ActivationDisposableKeys', SafetyController::class],
    ['getSecretQuestion', SafetyController::class],
    ['setSecretQuestion', SafetyController::class],
    ['getAccessIpStatus', SafetyController::class],
    ['setAccessIpStatus', SafetyController::class],
    ['GetDisposableKeys', SafetyController::class],
    ['SetDisposableKeys', SafetyController::class],
    ['ExportDisposableKeys', SafetyController::class],
    ['SetAntifishing', SafetyController::class],
    ['SetMagic', SafetyController::class],
    ['GetMagic', SafetyController::class],
    ['CreatePayPass', SafetyController::class],
    ['ChangePayPass', SafetyController::class],
    ['ChangePass', SafetyController::class],
    ['GetKeywords', ServiceComandController::class],
    ['GetKeytsKeywords', ServiceComandController::class],
    ['GetKeyts', ServiceComandController::class],
    ['GetCustomCurr', ServiceComandController::class],
    ['GetSearchMomentalKeywords', ServiceComandController::class],
    ['GetFormFields', ServiceComandController::class],
    ['GetCurrKeywords', ServiceComandController::class],
    ['GetCustomCurrParams', VirtualActivesController::class],
    ['DeleteCustomCurr', VirtualActivesController::class],
    ['NewVA', VirtualActivesController::class],
    ['isLogged', LoginController::class],
    ['login', LoginController::class],
    ['logout', LoginController::class],
    ['user', UserController::class]
];

$router = new Router($routes);
