<?php 
namespace App\SRC\ADV;

use App\SRC\ADV\DKCP;
use App\SRC\FW\Response;
use App\SRC\FW\Request;
use App\SRC\ADV\GELF\Gelf;
use App\SRC\ADV\CustomParse;

class Delta
{   
    private $dkcp_api;

    public function __construct()
    {
       $this->dkcp_api = new DKCP(array(
        'URL'                => PROCESSING_URL,
        'LANG'               => LANGUAGE,
        'PROGRAM'            => PROGRAM,
        'PROGRAM_SKEYS'      => PROGRAM_SKEYS,
        'USER_LOGIN'         => DKCP_USER_LOGIN,
        'USER_PASSWORD'      => DKCP_USER_PASSWORD,
        'PATH_CERT'          => DKCP_PATH_CERT, 
        'CERT'               => DKCP_CERT, 
        'CERT_PASSWORD'      => DKCP_CERT_PASSWORD,
        'PROTOCOL_VERSION'   => PROTOCOL_VERSION,
        'BEFORE_SEND'        => function($cmd, $params){
            if ( !isset($params['no_cabinet_autorize']) && isset($_SESSION['id']) ) {
                $params['cabinet_ip'] = $_SERVER['REMOTE_ADDR'];
                
                if ( $cmd != 'cabinet_authorize' ) {
                    $params['cabinet_id']       = $_SESSION['id'];
                    if (USE_TOKEN) {
                        $params['auth_token']       = $_SESSION['auth_token'];
                    } else {
                        $params['cabinet_login']    = $_SESSION['login'];
                        $params['cabinet_password'] = md5($_SESSION['password'] . $params['ext_transact']);
                    }
                    // $params['is_mobile']        = $_SESSION['is_mobile'];
                    // $params['type_auth']        = $_SESSION['type_auth'];
                }
            } else {
                if (isset($params['cabinet_password'])) {
                    $params['cabinet_password'] = md5($params['cabinet_password'] . $params['ext_transact']);
            
                }
            }
            if (isset($params['cabinet_pay_password'])) {
                $params['cabinet_pay_password'] = md5($params['cabinet_pay_password']);
            }

            $params['device_fingerprint'] = Request::get_param('device_fingerprint');
            
            // ms/*
            // if ( $cmd == 'getlist_keywords' ) {
            //     unset($params['password']);
            //     unset($params['login']);
            // }
            
            // if ( need_log($cmd) ) {
                // write_log('-----------------------------------------------------------------------------------------------------------------------------');
                // write_log('HTTP_USER_AGENT: ' . $_SERVER['HTTP_USER_AGENT']);
                // write_log('REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR']);
                // write_log('params: ' . print_r($params, 1));
            // }
            return $params;
        },
        
        'RESPONSE_BEFORE_PARSE' => function($cmd, $url, $params, $response){
            if ($cmd == 'getlist_finoperation_light' && isset($_GET['data'])) {
                $parse = new CustomParse();
                $parse->toExcele($cmd, $url, $params, $response, 'history');  
            }
        },
        
        'RESPONSE_ERROR_PARSE' => function($cmd, $response, $errors){
            // if ( need_log($cmd) ) {
                // write_log('parsed: ' . print_r($response, 1));
                
                // write_short_log(true, $_SERVER['REMOTE_ADDR'] . ' E ' . str_pad($cmd, 40) . ': ' . $response, false);
                
                // foreach ( $errors as $error ) {
                    // write_log('parsed error: ' . print_r($error, 1));
                // }
            // }
        },
        
        'RESPONSE_AFTER_PARSE' => function($cmd, $res, $response){
            // if ( need_log($cmd) ) {
                // write_log('parsed: ' . print_r($response, 1));
                
            // }
            
            if ( $res == True ) {
                
                // if ( need_log($cmd) ) {
                    // write_short_log(true, str_pad($_SERVER['REMOTE_ADDR'], 15) . ' : ' . str_pad($cmd, 40) . ': ' . $response['result_text'], false);
                // }
                
                if ( array_key_exists('colnames', $response['table']) == True ) {
                    if ( array_key_exists('colvalues', $response['table']) == False ) {
                        $response['table']['colvalues'] = array();
                    }
                } else {
                    foreach ( $response['table'] as $key => $value ) {
                        if ( array_key_exists('colvalues', $value) == False ) {
                            $response['table'][$key]['colvalues'] = array();
                        }
                    }
                }
                
                // fix
                // если одна таблица
                if ( array_key_exists('colnames', $response['table']) == True ) {
                    $response['tables'] = array($response['table']);
                } else {
                    $response['tables'] = $response['table'];
                    $response['table']  = $response['tables'][0];
                }
                
                // if ( need_log($cmd) and $response['table']['rowcount'] > 0 ) {
                    // write_short_log(false, ' (rows: ' . $response['table']['rowcount'] . ')', false);
                // }
            }
            
            // if ( need_log($cmd) ) {
                // write_short_log(false, '', true);
            // }
            
            // отключаем систему
            // if ( defined('SYSTEM_SHUTDOWN') ) {
            //     if ( SYSTEM_SHUTDOWN ) {
            //         $response['result']           = 1;
            //         $response['result_text']      = SYSTEM_SHUTDOWN_RESULT_TEXT;
            //         $response['result_text_info'] = SYSTEM_SHUTDOWN_RESULT_TEXT_INFO;
            //     }
            // }
            
            return $response;
        },
        
        'CACHE' => function($cmd, $params, $script, $free) {
            if ( in_array($cmd, array('getlist_keywords', 'getlist_files_info', 'getlist_field_type')) ) {
                return 60 * 60 * 12;
            }
        }
        ));
        $this->gray_log = new Gelf(); 
    }
    public function DeltaCMD($cmd, $params = [], $script = null, $free = False){
        // global $dkcp_api;
        $dkcp_cmd = $this->dkcp_api->cmd($cmd, $params, $script, $free);
        $this->gray_log->to_graylog(LOG_INFO, $cmd, $dkcp_cmd, $params, $script);
        if (!$dkcp_cmd[0]) {
            Response::json(['error' => 'DKCP Error']);
        }
        if ($dkcp_cmd[1]['result']) {
            if ($dkcp_cmd[1]['result'] == '857' || $dkcp_cmd[1]['result'] == '856') {
                $dkcp_cmd[1]['repeat'] = Request::json();
                Response::json($dkcp_cmd[1], 'repeat');
            } else {
                Response::json($dkcp_cmd[1], 'answer');
            }
        }
        return $dkcp_cmd;
    }

}