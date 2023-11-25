<?php
session_start();
include "setHeader.php";

include "konexioa.php";
require_once "CSFR.php";


if (isset($_SESSION['ERAB'])) {
    $id = $_POST['item_id'];
    $sql = "SELECT * FROM OBJEKTUA WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    $lerroa = mysqli_fetch_assoc($query);
    if ($query) {
        //kontsultaren lerroa zutabeen emaitzak gordetzen ditugu array batean, errezago atxitzeko
        $erab = $lerroa['erab'];
        if ($_SESSION['ERAB']['NAN'] == $erab) {
            //Elementuaren id-a lortzen dugu POST superglobaletik

            //Datu basetik ezabatzen da elementua eta orrialde nagusira bueltatzen gara.
            $sql = "DELETE FROM OBJEKTUA WHERE id='$id'";
            $produktuak = $conn->query($sql);
            $query = mysqli_query($conn, $sql);
            $toLog = $_SESSION['ERAB']['NAN'] . " erabiltzailea " . $id . " kamiseta ezabatu du";
            require_once 'logger.php';
            eventLogger($toLog);
            header("Location:./index.php");
        } else {
            header("Location:./login.php");
        }
    }
} else {
    header("Location:./login.php");
}
