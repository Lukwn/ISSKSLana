<?php
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(35));
    }
?>