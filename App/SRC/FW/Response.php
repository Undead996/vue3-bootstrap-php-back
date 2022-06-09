<?php

namespace App\SRC\FW;
use App\SRC\ADV\Session;

class Response
{
    public static function json($data = '1', $modal = false)
    {
        $res = [
            'isLogged' => Session::get('isLogged'),
            'body' => $data,
            'modal' => $modal
        ];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die;
    }
    
    public static function jsonError($data, $err) {
        $res = [
            'isLogged' => Session::get('isLogged'),
            'body' => $data,
            'error' => $err
        ];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die;
    }

    public static function txt($txt, $name) { 
        
        Header('Content-Type: text/plain');
        Header('Accept-Ranges: bytes');
        Header('Content-Length: '.strlen($txt));
        Header('Content-disposition: attachment; filename="'.$name.'.txt"'); 
        echo($txt);
        
        exit;
    }

    public static function print($data) {
        print_r($data);
        die;
    }
}