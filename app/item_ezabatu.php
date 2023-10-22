<?php
include "konexioa.php";

//Elementuaren id-a lortzen dugu POST superglobaletik
$id = $_POST['item_id'];

//Datu basetik ezabatzen da elementua eta orrialde nagusira bueltatzen gara.
$sql = "DELETE FROM OBJEKTUA WHERE id='$id'";
$produktuak = $conn->query($sql);
$query = mysqli_query($conn, $sql);
header("Location:./index.php");
?>