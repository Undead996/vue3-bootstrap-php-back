<?php
namespace App\Controllers;

use App\SRC\FW\Auth;
use App\SRC\FW\Request;

class LoginController
{
    public function login()
    {
        Auth::login(Request::json());
    }

    public function logout()
    {
        Auth::loguot();
    }

    public function isLogged()
    {
        Auth::isLogged();
    }
}