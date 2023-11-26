<?php
if (!isset($_SESSION['anticsrf'])) {
    $_SESSION['anticsrf'] = bin2hex(random_bytes(35));
}

function tokenEgiaztatu($token)
{
    if (!$token || $token !== $_SESSION['anticsrf']) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }
}
