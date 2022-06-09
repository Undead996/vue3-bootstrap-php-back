<?php
namespace App\SRC\FW;

class Router
{   
    private $name = false;
    private $controller = false;

    public function __construct($routes)
    {
        $this->check_rt($routes);
        $this->execute_rt();
    }

    private function check_rt($routes)
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !$_SERVER['QUERY_STRING'] ) {
            $c = 'getPage';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['QUERY_STRING']) {
            $c = array_pop(explode('/', mb_substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'))));
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $c = array_pop(explode('/', $_SERVER['REQUEST_URI']));
        }
        foreach($routes as $rt) {
            if ($rt[0] === $c) {
                $this->name = $rt[0];
                $this->controller = $rt[1];
                break;
            }
        }
    }

    private function execute_rt()
    {   
        if ($this->name && $this->controller) {
            $name = $this->name;
            $controller = new $this->controller();
            $controller->$name();
        } else {
            http_response_code(400);
        }
    }
}