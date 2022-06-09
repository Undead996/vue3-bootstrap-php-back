<?php
namespace App\SRC\ADV\GELF;

class Message
{   
    private $msg;
    public function __construct($confData, $level, $params)
    {   
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        } else {
            $id = 'no authorize';
        }
        $this->msg = [
            'version' => $confData['version'],
            'host' => $confData['host'],
            'short_message' => $params,
            'timestamp' => microtime(),
            'user_ip' => $_SERVER['REMOTE_ADDR'],
            'user_id' => $id,
            'url' => $this->get_act_url(),
            'script' => $_SERVER['SCRIPT_NAME'],
            'level' => $level,
            '_processing' => $confData['processing'],
            '_facility' => $confData['facility'],
        ];
    }
    public function setAdditional($arr)
    {
        foreach ( $arr as $key => $val) {
            $this->msg['_'.$key] = $val;
        }
    }
    private function get_act_url() {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }
    
    public function getMsg()
    {   
        return json_encode($this->msg);
    }
}

