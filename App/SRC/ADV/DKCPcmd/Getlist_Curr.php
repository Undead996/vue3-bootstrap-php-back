<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;

class Getlist_Curr
{
    public static function get()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_curr', [], 'dkcp/direct.py');
        return $answer['tables'][0]['colvalues'];
    }
}