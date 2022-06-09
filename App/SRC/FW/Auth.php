<?php

namespace App\SRC\FW;

use App\SRC\ADV\Session;
use App\SRC\ADV\Login;
use App\SRC\FW\Request;
use App\SRC\FW\Response;
use App\SRC\ADV\DKCPcmd\Get_User_Info;
use App\SRC\ADV\DKCPcmd\Get_Last_Autorization_Info;

class Auth
{   
    public static function check()
    {   
        $uri = array_pop(explode('/', $_SERVER['REQUEST_URI']));
        // Response::json($uri);
        $session = new Session(SESSION_COOKIE_NAME, ['session_domain' => SESSION_DOMAIN]);
        if (!$session->session_start_secure() && $uri != 'login' && $uri != 'isLogged') {
            Response::jsonError('Ошибка авторизации', ['error_code' => '4040', 'error_text' => 'Неавторизованный запрос '.$_SERVER['REQUEST_URI']]);
        }
    }

    public static function isLogged()
    {   
        if (Session::get('id')) {
            Get_User_Info::get();
        }
        Response::json([
            'id' => Session::get('id'),
            'antiphishing' => Session::get('antifishing'),
            'user_info' => Session::get('user_info'),
        ]);
    }

    public static function login($request)
    {   
        $login = new Login(Request::json());
        $res = $login->login($request);
        if ($res === '1') {
            Session::set('device_fingerprint', Request::get_param('device_fingerprint'));
            Get_User_Info::get();
            Get_Last_Autorization_Info::get();
            $info = array_merge(Session::get('user_info'), Session::get('last_autorization_info'));
            Response::json([
                'id' => Session::get('id'),
                'antiphishing' => Session::get('antifishing'),
                'user_info' => $info,
            ]);
        } else {
            Response::json($res, 'answer');
        }
    }

    public static function loguot()
    {   
        // $session = new Session(SESSION_COOKIE_NAME, ['session_domain' => SESSION_DOMAIN]);
        Session::logout(SESSION_COOKIE_NAME, SESSION_DOMAIN);
        Response::json();
    }
}