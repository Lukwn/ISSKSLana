<?php
session_start();

include "konexioa.php";
include "logout.php";

if (isset($_SESSION['ERAB'])) {
    $nan = $_SESSION['ERAB']['NAN'];
    $sql = "SELECT * FROM ERABILTZAILE WHERE NAN = '$nan'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        //kontsultaren lerroa zutabeen emaitzak gordetzen ditugu array batean, errezago atxitzeko
        $lerroa = mysqli_fetch_assoc($query);
        $izena = $lerroa['Izen_Abizenak'];
        $tlf = $lerroa['Telefonoa'];
        $jd = $lerroa['Jaiotze_data'];
        $mail = $lerroa['email'];
        $pass = $lerroa['pasahitza'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //js-a ez badu false bueltatzen hurrengo kodea egikaritzen da, non  insert-aren balioak atxitzen dira formulariotik
    $izab = $_POST['izab'];
    $nan = $_POST['NAN'];
    $tlf = $_POST['tlf'];
    $jd = $_POST['jd'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    //update-aren eskaera idazten dugu
    $sql = "UPDATE `ERABILTZAILE` SET `Izen_Abizenak`=?, `NAN`=?, `Telefonoa`=?, `Jaiotze_data`=?, `email`=?, `pasahitza`=? WHERE `NAN`=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $izab, $nan, $tlf, $jd, $mail, $pass, $_SESSION['ERAB']['NAN']);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Datuak eguneratu dira!")</script>';
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
    <title>Zure datuak</title>
    <link rel="stylesheet" href="datuakaldatu.css">
    <link rel="stylesheet" href="./barra.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header class="top-bar">
        <div class="barra">
        <a href="index.php" class="logo_esteka"><img class="logo" src="./img/bag.png" alt="Logo Alt Text"></a>
            <nav class="nav_barra">
                <ul>
                    <li class="li_barra"><a href="login.php">Log in</a></li>
                    <li class="li_barra"><a href="register.php">Register</a></li>
                    <li class="li_barra"><a href="datuakaldatu.php">Datuak aldatu</a></li>
                    <li class="li_barra"><a href="logout.php">Log out</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="gorputza">
        <div class="wrapper">
            <?php if (isset($_SESSION['ERAB'])) { ?>
                <form class="formularioa" method="POST" onsubmit="return erregistroaBaieztatu();">
                    <h1>Zure datuak aldatu,
                        <?php echo $_SESSION['ERAB']['izena']; ?>
                    </h1>
                    <div class="azalpen-test">
                        Izen Abizenak
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $izena; ?>" name="izab" id="izab" required>
                    </div>
                    <div class="azalpen-test">
                        NAN-a
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $nan; ?>" name="NAN" id="NAN" required>
                    </div>
                    <div class="azalpen-test">
                        Telefono zenbakia
                    </div>
                    <div class="input-box">
                        <input type="number" value="<?php echo $tlf; ?>" name="tlf" id="tlf" required>
                    </div>
                    <div class="azalpen-test">
                        Jaiotze data
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $jd; ?>" name="jd" id="jd" required>
                    </div>
                    <div class="azalpen-test">
                        E-maila
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $mail; ?>" name="mail" id="mail" required>
                    </div>
                    <div class="azalpen-test">
                        Pasahitza
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $pass; ?>" name="pass" id="pass" required>
                    </div>
                    <button type="submit" class="btn">Aldatu</button>
                </form>
            <?php } else { ?>
                <h1>Saioa hasi behar duzu erabiltzaile datuak aldatzeko.</h1>
                <button onclick="window.location.href = 'login.php'" class="btn">Saioa hasi</button>
            <?php } ?>
        </div>
    </div>

</body>

</html>