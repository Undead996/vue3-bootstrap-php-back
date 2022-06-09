<?php

namespace App\Controllers;

use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\Session;
use App\SRC\ADV\Delta;

class HistoryController
{
    public function GetFinoperationLight()
    {
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getlist_finoperation_light', $req['data'], "dkcp/statistics.py");
        Response::json($answer['tables'][0]['colvalues']);
    }
    public function GetParamsFinoperationLight()
    {
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('getparams_finoperation_light', $req['data'], "dkcp/statistics.py");
        Response::json([$answer['tables'], $answer['advanced']]);
    }

    public function CancelPayment()
    {
        $req = Request::json();
        $delta = new Delta();
        list($res, $answer) = $delta->DeltaCMD('cancel_payment', $req['data'], "fin.py");
        Response::json($answer, 'answer');
    }
}