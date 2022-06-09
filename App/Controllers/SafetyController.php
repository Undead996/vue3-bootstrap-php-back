<?php

namespace App\Controllers;

use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\Session;
use App\SRC\ADV\Delta;

class SafetyController
{
    public function ChangePass()
    {   
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('change_password', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

    public function ChangePayPass()
    {   
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('change_pay_password', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

    public function CreatePayPass()
    {   
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('create_pay_password', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

    public function SetAntifishing()
    {   
        $req = Request::json();
        $delta = new Delta();
        $req['data']['string'] = iconv("utf-8", "windows-1251", $req['data']['string']);
        list($res, $answer) = $delta->DeltaCMD('set_antifishing', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

    public function GetMagic()
    {   
        $delta = new Delta();

        list($res, $answer) = $delta->DeltaCMD('getlist_magic', [], "dkcp/security.py");
        Response::json($answer['advanced']);
    }

    public function SetMagic()
    {   
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('change_magic', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

    public function getSecretQuestion()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_secret_question', [], "dkcp/options.py");
        $res = [
            'keywords' => [],
            'advanced' => []
        ]; 
        foreach($answer['table']['colvalues'] as $key => $val) {
            $res['keywords'][$key]['code'] = $val['code'];
            $res['keywords'][$key]['value'] = $val['name'];
        }
        array_push($res['keywords'], ['code'=> 'custom', 'value' => 'Свой вопрос']);
        $res['advanced'] = $answer['advanced'];
        Response::json($res);
    }

    public function setSecretQuestion()
    {   
        $req = Request::json();
        $params = [];
        foreach ($req['data'] as $key => $val) {
            if ($val != false) {
                $params[$key] = iconv("utf-8", "windows-1251", $val);
            }
        }
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('set_secret_question', $params, "dkcp/options.py");
        Response::json($answer, 'answer');
    }

    public function setAccessIpStatus()
    {   
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('set_access_ip_status', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

    public function getAccessIpStatus()
    {
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('get_access_ip_status', [], "dkcp/security.py");

        $IpAssocArr = array();
        $selfIp = $_SERVER['REMOTE_ADDR'];
        if ( $answer['advanced']['ip'] != '' ) {
            
            $IpArr = explode(';', $answer['advanced']['ip']);
          
            $ipStatus = true;
            for ( $i = 0; $i < count($IpArr); $i++ ) {
                $IpAssocItem = explode(':', $IpArr[$i]);
                $IpRanges = explode('-', $IpAssocItem[0]);
                $IpAssocArr[$i]['addr_start'] = $IpRanges[0];
                if ( count($IpRanges) > 1 )
                    $IpAssocArr[$i]['addr_end'] = $IpRanges[1];
                else
                    $IpAssocArr[$i]['addr_end'] = $IpRanges[0];
                $IpAssocArr[$i]['enable'] = $IpAssocItem[1];
            }

            if ( $IpAssocArr[0]['enable'] == '' )
                $ipStatus = false;
		
	        if ( $IpAssocArr[0]['addr_start'] == "0.0.0.0" && $IpAssocArr[0]['addr_end'] == "255.255.255.255" ) {
		        $ipStatus = false;
                unset($IpAssocArr[0]);
	        }
            
        } else {
            $ipStatus = false;
        }
        Response::json([$ipStatus, $IpAssocArr, $selfIp]);
    }

    private function ArrSetKeys($answer)
    {   
        $response['visible'] = isset($answer['advanced']['visible']) ? $answer['advanced']['visible'] : '1';
        $response['active'] = $answer['advanced']['active'];
        $arr = [];
        if ( $answer['advanced']['disposable_keys'] != "" ) {
            $KeysArr = explode(',', $answer['advanced']['disposable_keys']);
            $numnext = array_shift($KeysArr);
            for ( $i=1; $i<$numnext; $i++ )
                array_unshift($KeysArr, '');

            foreach ($KeysArr as $key => $val) {
                $arr["$key"] = $val;
            }

        }
        $response['onekeys'] = array_chunk($arr, 5, true);
        return $response;
    }

    public function GetDisposableKeys()
    {   
        $params = [];
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('get_disposable_keys', $params, "dkcp/security.py");
        Response::json($this->ArrSetKeys($answer));
    }

    public function SetDisposableKeys()
    {
        $params = [];
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('set_disposable_keys', $params, "dkcp/security.py");
        Response::json($this->ArrSetKeys($answer));
    }

    public function ExportDisposableKeys()
    {
        $req = Request::json();
        $tmp = $req['data'];
        $keys = array_merge(...$tmp);
        $file = '';
        foreach ($keys as $key => $val) {
            $file .= "Ключ $key: $val;\r\n";
        }
        Response::txt($file, 'Keys');
    }

    public function ActivationDisposableKeys()
    {   
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('activation_disposable_keys', $req['data'], "dkcp/security.py");
        Response::json($answer, 'answer');
    }

}