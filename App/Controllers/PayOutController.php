<?php

namespace App\Controllers;

use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\Session;
use App\SRC\ADV\Delta;

class PayOutController
{
    public function getOperatorsListMenu()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_group', [], 'direct.py');
        Response::json($this->get_left_menu_pay($answer['table']['colvalues']));
        // Response::json($answer['table']['colvalues']);
    }

    public function menu_pay_sub($list) 
    {   
        $submenu = $list;
        foreach ( $list as $subgroup ) {
        if ($subgroup['root']) {
            foreach ( $submenu as $key => &$sub_item) {
                if ($sub_item['num'] == $subgroup['root']) {
                    isset($sub_item['childs']) ? array_push($sub_item['childs'], $subgroup['num']) : $sub_item['childs'] = [$subgroup['num']];
                }
            }
        }
    }
    return $submenu;
    }
    
    public function get_left_menu_pay($list) 
    {
        return $this->menu_pay_sub($list);
    }
}