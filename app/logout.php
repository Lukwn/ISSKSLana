<?php
if (isset($_REQUEST['logout'])) {
    if (isset($_SESSION['ERAB'])) {
        session_destroy();
        header("Location: /index.php");
        exit();
    }
    else{
        header("Location: /login.php");
    }
}
?>