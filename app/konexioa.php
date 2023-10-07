<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "database";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Konexioa huts egin du: " . mysqli_connect_error());
}
?>