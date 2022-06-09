<?php

namespace App\Controllers;

use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\Session;
use App\SRC\ADV\Delta;

class GetFileController
{
    public function ExportDisposableKeys()
    {
        $req = json_decode(Request::get(), true);
        $keys = array_merge(...$req);
        $file = '';
        foreach ($keys as $key => $val) {
            $file .= "Ключ $key: $val;\r\n";
        }
        Response::txt($file, 'keys');
    }

    public function ExportHistory()
    {
        $req = json_decode(Request::get(), true);
        $delta = new Delta();
        $req['device_fingerprint'] = Session::get('device_fingerprint');
        list($res, $answer) = $delta->DeltaCMD('getlist_finoperation_light', $req, "dkcp/statistics.py");
    }
}