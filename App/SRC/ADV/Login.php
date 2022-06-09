<?php

namespace App\SRC\ADV;
use App\SRC\ADV\Delta;
use App\SRC\ADV\Session;

class Login
{   
    public function __construct($req)
    {   
        $this->reqData = $req;
        $this->delta = new Delta();
    }

    public function loginn ()
    {
        return true;
    }

    public function login()
    {
        $regconfirm	    = $this->get_val('regconfirm');
		$sms_input 		= $this->get_val('sms_input');
		$onekey 		= $this->get_val('onekey');
		$magicword 		= $this->get_val('magicword');
		$login 			= $this->get_val('cabinet_login');
		$password 		= $this->get_val('password');
		$sms_status_tpl = $this->get_val('sms_status_tpl');
		// $device_fingerprint = $this->set_fingerprint($this->get_val('device_fingerprint'));
		// pre($device_fingerprint);
		$sms_confirm_value = $this->get_val('sms_confirm_value');

		
		$is_mobile = '1';
		if (strpos($login, '@') > 0)
			$is_mobile = '0';
		
		$params = array();	
		
		$params['type_auth'] 		= "email_paypass";
		$params['cabinet_login'] 	= $login;
		$params['cabinet_password'] = $password; // Пароль будет обернут дальше
		$params['is_mobile'] 		= $is_mobile;
		// $params['sms_input'] 		= $sms_input;
		$params['sms_confirm'] 		= $regconfirm;
		$params['onekey'] 			= $onekey;
		$params['magic_word'] 		= @iconv("utf-8", "windows-1251", $magicword);
		$params['cabinet_user_ip'] 	= $_SERVER['REMOTE_ADDR']; 
		// $params['device_fingerprint'] = $device_fingerprint;
		if (USE_TOKEN) {
			$params['token_lifetime'] 	= TOKEN_LIFETIME;
		}

		if ($sms_confirm_value) {
			$params['sms_confirm_value'] = $sms_confirm_value;
		}
		
		// pre($params);
		list($res, $answer) = $this->delta->DeltaCMD('cabinet_authorize', $params, "cts.py");
        // print_r($_SESSION);
        // print_r($answer);
        if ($res) {
            if ($answer['result'] == '0') {
                Session::set('isLogged', true);
                Session::set('id', $answer['advanced']['user_id']);
                Session::set('user_name', $answer['advanced']['name']);
                Session::set('antifishing', $answer['advanced']['antifishing']);
                Session::set('design', $answer['advanced']['design']);
                Session::set('stl', $answer['advanced']['stl']);
                Session::set('kesp_is', $answer['advanced']['kesp_is']);
                Session::set('auth_token', $answer['advanced']['auth_token']);
                Session::set('passport_code', explode(',', $answer['advanced']['passport_code']));
                Session::set('passport_serial', explode(',', $answer['advanced']['passport_serial']));
                
                return '1';
            } else {
                return $answer;
            }
        } else {
            return false;
        }
		
    }

    private function get_val($name) {
        $value = '';
		
		if ( isset($this->reqData[$name]) ) 	
			$value = $this->reqData[$name];
		
		$this->tplvars[$name] = $value;
		
		return $value;
    }

}