<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'router/api.php';
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include 'router/web.php';
}
