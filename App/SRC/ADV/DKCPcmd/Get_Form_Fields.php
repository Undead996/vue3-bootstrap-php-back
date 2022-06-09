<?php
namespace App\SRC\ADV\DKCPcmd;

use App\SRC\ADV\Delta;
use App\SRC\ADV\DKCPcmd\Getlist_Curr;

class Get_Form_Fields
{
    public static function get($params)
    {
        $delta = new Delta();
        list($res, $fields) = $delta->DeltaCMD('get_form_fields', $params, 'dkcp/direct.py');
        list($res, $types) = $delta->DeltaCMD('getlist_field_type', [], 'dkcp/direct.py');
        foreach ($fields['tables'][0]['colvalues'] as &$field) {
            foreach ($types['tables'][0]['colvalues'] as $type) {
                if ($field['type_field'] == $type['num']) {
                    $field['list'] = $type['list'];
                    if (!$field['re'] && $type['regexp']) {
                        $field['re'] = $type['regexp'];
                    }
                }
            }
            if ($field['type_field'] == 'CURR') {
                $lists = Getlist_Curr::get();
                $field['lists'] = [];
                foreach ($lists as $val) {
                    array_push($field['lists'], ['code' => $val['code'], 'value' => $val['full_name']]); 
                }
            }
        }
        return $fields['tables'][0]['colvalues'];
    }
}