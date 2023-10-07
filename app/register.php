<?php
include "konexioa.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //js-a ez badu false bueltatzen hurrengo kodea egikaritzen da, non  insert-aren balioak atxitzen dira formulariotik
    $izab = $_POST['izab'];
    $nan = $_POST['NAN'];
    $tlf = $_POST['tlf'];
    $jd = $_POST['jd'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    //insert-a idazten dugu eta prestatzen dugu egikaritzeko
    $sql = "INSERT INTO `ERABILTZAILE` (`Izen_Abizenak`, `NAN`, `Telefonoa`, `Jaiotze_data`, `email`, `pasahitza`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $izab, $nan, $tlf, $jd, $mail, $pass);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Erabiltzaile berria sortuta!")</script>';
    } else {
        echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
    }

    //datu basearekin konexioa ixten dugu
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="forms.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="./register.js"></script>
</head>

<body>
    <div class="wrapper">
        <form action="index.php" class="formularioa" method="POST" onsubmit="return erregistroaBaieztatu();">
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" placeholder="Izen-Abizenak" name="izab" id="izab" required>
                <i class='bx bx-user-circle'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="NAN, eg: 11111111Z" name="NAN" id="NAN" required>
            </div>
            <div class="input-box">
                <input type="number" placeholder="Telefonoa, 9 zenbaki" name="tlf" id="tlf" required>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Jaiotze data, eg: 2021-08-26" name="jd" id="jd" required>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Mail, eg: adibidea@zerbitzaria.extentsioa" name="mail" id="mail"
                    required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Pasahitza" name="pass" id="pass" required>
                <i class='bx bx-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Erregistratu</button>
            <div class="register-link">
                <p>Jadanik kontu bat duzu?<a href="./login.php">Saioa hasi</a></p>
            </div>
        </form>
    </div>
</body>

</html>