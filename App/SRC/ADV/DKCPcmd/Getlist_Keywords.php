<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;
use App\SRC\FW\Response;

class Getlist_Keywords
{
    
    public static function findGroup($group)
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_keywords', [], 'ms/direct.py');
        $keywords = [];
        foreach($answer['table'][0]['colvalues'] as $val) {
            if ($val['group'] == $group) {
                array_push($keywords, $val);
            }
        }
        return $keywords;
    }
}