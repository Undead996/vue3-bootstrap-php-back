<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;

class Create_Transfer_Template
{
    
    public static function create($params)
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('create_transfer_template', $params, 'template.py');
        return $answer;
    }
}