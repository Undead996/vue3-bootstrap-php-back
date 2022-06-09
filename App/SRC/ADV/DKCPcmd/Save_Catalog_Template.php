<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;

class Save_Catalog_Template
{
    
    public static function create($params)
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('save_catalog_template', $params, 'template.py');
        return $answer;
    }
}