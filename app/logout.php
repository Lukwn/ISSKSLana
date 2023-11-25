<?php
include "setHeader.php";
//Logout request bat egiten badu fitxategi honen kodea egikaritzen da
if (isset($_REQUEST['logout'])) {
    //ERAB sesioa hasita badago amaitzen dugu, gero orrialde nagusira  bueltatuko gara
    if (isset($_SESSION['ERAB'])) {
        $toLog = "Log out - " . $_SESSION['ERAB']['NAN'];
		require_once 'logger.php';
		eventLogger($toLog);
        session_destroy();
        header("Location: /index.php");
        exit();
    }
    else{
        header("Location: /index.php"); 
    }
}
?>