<?php 

namespace App\SRC\FW;

class Request
{
    public static function json() 
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        return $data;
    }

    public static function get()
    {
        return $_GET['data'];
    }

    public static function get_param($name)
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        if (isset($data[$name])) {
            return $data[$name];
        } elseif ($name == 'device_fingerprint') {
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            }
        } else {
            return trigger_error("Отстутствует параметр '$name'", E_USER_ERROR);
        }
    }

    public static function get_file_from_base64($file)
    {
        list($type, $data) = explode(';', $file);
        list(, $data)      = explode(',', $data);
        return base64_decode($data);
    }
}