<?php
namespace App\Controllers;

use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\Session;
use App\SRC\ADV\DKCPcmd\Getlist_Keywords;
use App\SRC\ADV\DKCPcmd\Getlist_Custom_Curr;
use App\SRC\ADV\DKCPcmd\Create_Transfer_Template;
use App\SRC\ADV\DKCPcmd\Save_Catalog_Template;
use App\SRC\ADV\DKCPcmd\Get_Search_Momental;
use App\SRC\ADV\DKCPcmd\Get_Form_Fields;
use App\SRC\ADV\DKCPcmd\Getlist_Curr;
use App\SRC\ADV\DKCPcmd\Getlist_Keyt;

class ServiceComandController
{
    public function GetKeywords()
    {   
        $req = Request::json();
        $keywords = Getlist_Keywords::findGroup($req['group']);
        Response::json($keywords);
    }
    public function GetCustomCurr()
    {
        $answer = Getlist_Custom_Curr::getList();
        Response::json($answer);
    }
    public function GetSearchMomentalKeywords()
    {
        $req = Request::json();
        Response::json(Get_Search_Momental::get_keywords($req['data']));
    }
    public function GetFormFields()
    {
        $req = Request::json();
        Response::json(Get_Form_Fields::get($req['data']));
    }
    public static function getCurrKeywords()
    {
        $lists = Getlist_Curr::get();
        $field = [];
        foreach ($lists as $val) {
            array_push($field, ['code' => $val['code'], 'value' => $val['full_name']]); 
        }
        Response::json($field);
    }
    public static function GetKeytsKeywords()
    {
        $req = Request::json();
        $lists = Getlist_Keyt::get($req['data']);
        $field = [];
        foreach ($lists as $val) {
            $name = $val['curr'] . ' ' . ' ' . $val['keyt'] . ' ' . $val['name'] . ' (' . $val['balance'] . ')' ;
            array_push($field, ['code' => $val['keyt'], 'value' => $name]); 
        }
        Response::json($field);
    }
    public static function GetKeyts()
    {
        $req = Request::json();
        $answer = Getlist_Keyt::get($req['data']);
        Response::json($answer);
    }

    public static function CreateTransferTemplate()
    {
        $req = Request::json();
        $res = Create_Transfer_Template::create($req['data']);
        Response::json($res);
    }

    public static function SaveCatalogTemplate()
    {
        $req = Request::json();
        $res = Save_Catalog_Template::create($req['data']);
        Response::json($res);
    }
}