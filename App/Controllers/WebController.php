<?php

namespace App\Controllers;

class WebController
{
    public function getPage()
    {
        require './static/index.html';
    }
}