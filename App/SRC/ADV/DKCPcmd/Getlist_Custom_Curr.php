<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;

class Getlist_Custom_Curr
{
    
    public static function getList()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_custom_curr', [], 'dkcp/custom_curr.py');
        foreach ($answer['table']['colvalues'] as &$val) {
            if ($val['logo']) {
                $val['logo'] = "data:image/png;base64, ".$val['logo'];
            }
        }
        return $answer['table']['colvalues'];
    }
}