<?php
include "setHeader.php";
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

function tokenEgiaztatu($token)
{
    if (!$token || $token !== $_SESSION['token']) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }
}
