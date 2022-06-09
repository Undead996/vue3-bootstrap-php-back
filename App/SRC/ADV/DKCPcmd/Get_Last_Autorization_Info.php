<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;
use App\SRC\ADV\Session;

class Get_Last_Autorization_Info
{
    
    public static function get()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('get_last_autorization_info', [], 'dkcp/cts.py');
        $info = $answer['advanced'];
        Session::set('last_autorization_info', $info);
    }
}