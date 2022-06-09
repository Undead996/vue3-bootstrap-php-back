<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;
use App\SRC\ADV\Session;

class Get_User_Info
{
    
    public static function get()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('get_user_info', [], 'dkcp/register.py');
        $info = [];
        foreach ($answer['tables']['0']['0']['colvalues'] as $val) {
            $info[$val['alias']] = $val;
        }
        Session::set('user_info', $info);
    }
}