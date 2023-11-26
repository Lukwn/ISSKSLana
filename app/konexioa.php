<?php
//aldagaietan gordetzen ditugu konexioaren balioak
$servername = "db";
$username = "5YJBO8FCH1R2poV";
$password = "HYLXpp1lrxI36o0";
$dbname = "database";

//konexioa saiatzen dugu
$conn = mysqli_connect($servername, $username, $password, $dbname);

//konexioa errorea ematen badu errore kodea ateratzen dugu
if (!$conn) {
    require_once 'logger.php';
	errorLogger("Konexioa huts egin du: " . mysqli_connect_error());
    die("Errore bat egon da");
}
?>