<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;

class Getlist_keyt
{
    public static function get($params)
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_keyt', $params, 'dkcp/keyt.py');
        return $answer['tables'][0]['colvalues'];
    }
}