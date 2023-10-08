<?php
//aldagaietan gordetzen ditugu konexioaren balioak
$servername = "db";
$username = "root";
$password = "root";
$dbname = "database";

//konexioa saiatzen dugu
$conn = mysqli_connect($servername, $username, $password, $dbname);

//konexioa errorea ematen badu errore kodea ateratzen dugu
if (!$conn) {
    die("Konexioa huts egin du: " . mysqli_connect_error());
}
?>