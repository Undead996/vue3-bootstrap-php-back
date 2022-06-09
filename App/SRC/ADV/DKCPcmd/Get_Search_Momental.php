<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;

class Get_Search_Momental
{
    public static function get_keywords($type = false)
    {
        $delta = new Delta();
        if ($type) {
            $params['form_type'] = $type;
        }
        list($res, $answer) = $delta->DeltaCMD('get_search_momental', $params, 'dkcp/direct.py');
        $keywords = [];
        foreach($answer['tables'][0]['colvalues'] as $val) {
            $val['value'] = $val['name'];
            unset($val['name']);
            array_push($keywords, $val);
        }
        return $keywords;
    }
}