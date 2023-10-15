<?php
include "konexioa.php";

$id = $_POST['item_id'];

$sql = "DELETE FROM OBJEKTUA WHERE id='$id'";
$produktuak = $conn->query($sql);
$query = mysqli_query($conn, $sql);
header("Location:./index.php");
?>