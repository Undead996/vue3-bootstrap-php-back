<?php
namespace App\SRC\ADV\GELF;

use App\SRC\ADV\GELF\Message;
use App\SRC\ADV\GELF\SendMSG;

class Gelf
{   
    public function to_graylog($level, $cmd, $data, $params, $script)
    {
        if (gettype($cmd) == 'string') {
            $cmd = [
                [$cmd, $params, $script]
            ];
            $data = [$data];
        }
        foreach ($cmd as $key => $val) {
            $cmd_name = $val['0'];
            if (isset($val['1']['cabinet_password'])) {
                unset($val['1']['cabinet_password']);
            }
            if (isset($val['1']['cabinet_pay_password'])) {
                unset($val['1']['cabinet_pay_password']);
            }
            $full_req = json_encode($val['1'], JSON_UNESCAPED_UNICODE);
            $cmd_url = $val['2'];
            $dkcp_answer = $data[$key]['1'];
            if ($this->need_log($cmd_name)) {
                $full_response = json_encode($dkcp_answer, JSON_UNESCAPED_UNICODE);
            } else {
                $full_response = 'no need';
            }
            
            
            // if ($dkcp_answer['result'] !== '0') {
                // $level = LOG_NOTICE;
            // }
            
            if (gettype($dkcp_answer) == 'string' ) {
                $exeption = [
                    'short' => "ERROR: ".$cmd_name.' HTTP_ERROR',
                    'str' => $dkcp_answer
                ];
                    $this->exeption_to_graylog(LOG_ERR, $exeption);
                continue;
            }
            

                $full_req = $this->checkLength(GELF_CMD_REQ_MAX_SIZE, GELF_CMD_REQ_MAX_LENGTH, $full_req);
                $full_response = $this->checkLength(GELF_CMD_RES_MAX_SIZE, GELF_CMD_RES_MAX_LENGTH, $full_response);
                
                $message = new Message(GELF_PARAMS, $level, $cmd_name." ".$data[$key]['1']['result_text']);
                $add = [
                    'dkcp_cmd' => $cmd_name,
                    'request_url' => PROCESSING_URL.$cmd_url,
                    'ext_transact' => $dkcp_answer['ext_transact'],
                    'transact' => $dkcp_answer['transact'],
                    'dkcp_result' => $dkcp_answer['result'],
                    'request_fields' => $full_req,
                    'response' => $full_response,
                ];
                $message->setAdditional($add);
                $msg = $message->getMsg();
                $post = new SendMSG(GELF_URL, $msg);
                $headers = ['Content-Type: application/json'];
                $post->setHeaders($headers);
                $res = $post->execMsg();
        }
    }

    public function exeption_to_graylog($level, $exeption) 
    {
        $message = new Message(GELF_PARAMS, $level, $exeption['short']);
        $add = [
            'error_text' => $exeption['str']
            ];
        $message->setAdditional($add);
        $msg = $message->getMsg();
        $post = new SendMSG(GELF_URL, $msg);
        $headers = ['Content-Type: application/json'];
        $post->setHeaders($headers);
        $res = $post->execMsg();
    }

    private function checkLength($max, $to, $str)
    {
        if (strlen($str) > $max) {
           return substr($str, 0, $to).'...  ['.strlen($str).' bytes]';
        } else {
            return $str;
        }
    }

    private function need_log($cmd) {
        return !in_array($cmd, Array('getlist_informator', 'getlist_curr', 'getlist_keyt1', 'getlist_keywords', 'getlist_files_info'));
        // return true;
    }
    
    
}