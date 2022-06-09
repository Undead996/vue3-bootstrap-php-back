<?php
namespace App\SRC\FW;
use App\SRC\FW\Response;

class ErrorHandler
{   
    public function __construct()
    {
        set_error_handler(array($this, 'error_handler'));
    }

    public function error_handler($errno, $errstr, $errfile, $errline)
    {
        $errors = array( //Формирования массива констант ошибок
            E_WARNING => 'E_WARNING',
            E_NOTICE => 'E_NOTICE',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED'
        );
        if (in_array($errno, ERROR_NO_REPORTING_VAL)) {
            return;
        }
        $err_to_log = [
             'str' => "$errors[$errno]: $errstr \n в $errfile на $errline строке. <br/>",
             'short' => "Error: $errors[$errno] <br/>",
        ];
        // exeption_to_graylog(LOG_WARNING, $err_to_log);
        if (DISPLAY_ERRORS) {
            Response::jsonError('PHPError', ['error_code' => $errno, 'error_text' => $err_to_log['str']]);
            die;
        }
    }
}

