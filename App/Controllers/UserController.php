<?php

namespace App\Controllers;
use App\SRC\FW\Response;
class UserController
{
    public function user()
    {
        Response::json($_SESSION);
    }
}