<?php

namespace App\Controllers;

use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\Session;
use App\SRC\ADV\Delta;

class VirtualActivesController
{
    public function NewVA()
    {   
        $req = Request::json();
        $delta = new Delta();
        if (isset($req['data']['logo'])) {
            $req['data']['logo'] = Request::get_file_from_base64($req['data']['logo']); 
        }
        if (empty($req['data']['export_postings_how_fields'])) {
            unset($req['data']['export_postings_how_fields']);
            unset($req['data']['export_postings_form']);
        } else {
            $how_fields = $req['data']['export_postings_how_fields'];
            $strStart = "<?xml version='1.0' encoding='UTF-8'?><response><status>2</status><result_text>Операция успешно завершена. </result_text><result>0</result><date>20220519154324</date>";
            $tableH = '<table col="2" name="how_form_fields" row="'.(string) count($how_fields).'"><colnames><code display="show" type="int">code</code><value display="show" type="str">value</value></colnames><excluded_colnames />';
            $values = '';
            foreach ($how_fields as $key => $value) {
                $values .= "<colvalues><code>".(string)$key."</code><value>".(string)$value."</value></colvalues>";
            }
            $strEnd = "</table><transact>0</transact><status_text>Команда выполнена</status_text><ext_transact>0</ext_transact><advanced /></response>";
            $req['data']['export_postings_how_fields'] = @iconv("utf-8", "windows-1251", $strStart.$tableH.$values.$strEnd);
        }
        list($res, $answer) = $delta->DeltaCMD('create_custom_curr', $req['data'], 'dkcp/custom_curr.py');
        Response::json($answer, 'answer');
    }

    public function DeleteCustomCurr()
    {   
        $req = Request::json();
        $delta = new Delta();   
        list($res, $answer) = $delta->DeltaCMD('delete_custom_curr', ['code' => $req['code']], 'dkcp/custom_curr.py');
        Response::json($answer, 'answer');
    }
    public function GetCustomCurrParams()
    {
        $req = Request::json();
        $delta = new Delta();   
        list($res, $answer) = $delta->DeltaCMD('getparams_custom_curr', ['code' => $req['code']], 'dkcp/custom_curr.py');
        if ($answer['advanced']['logo']) {
            $answer['advanced']['logo'] = "data:image/png;base64, ".$answer['advanced']['logo'];
        }
        Response::json($answer['advanced']);
    }
}