<?php
session_start();

include "konexioa.php";
include "logout.php";
require_once "CSFR.php";


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
        $salt = $lerroa['salt'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
	tokenEgiaztatu($token);
    //js-a ez badu false bueltatzen hurrengo kodea egikaritzen da, non  insert-aren balioak atxitzen dira formulariotik
    $izab = $_POST['izab'];
    $nan = $_POST['NAN'];
    $tlf = $_POST['tlf'];
    $jd = $_POST['jd'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    if ($pass != '') {
        //gatza sortu “16 byte”
        $salt = bin2hex(random_bytes(16));

        //pasahitza eta gatza batu
        $passSalt = $pass . $salt;

        //hash-a sortu
        $hashedpass = password_hash($passSalt, PASSWORD_DEFAULT);
        $sql = "UPDATE `ERABILTZAILE` SET `Izen_Abizenak`=?, `NAN`=?, `Telefonoa`=?, `Jaiotze_data`=?, `email`=?, `pasahitza`=?, `salt`=? WHERE `NAN`=?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            die("Errorea: " . mysqli_error($conn)); //Hau log-ean sartu beharko da.
        }
        mysqli_stmt_bind_param($stmt, "ssssssss", $izab, $nan, $tlf, $jd, $mail, $hashedpass, $salt, $_SESSION['ERAB']['NAN']);
    } else {
        $sql = "UPDATE `ERABILTZAILE` SET `Izen_Abizenak`=?, `NAN`=?, `Telefonoa`=?, `Jaiotze_data`=?, `email`=? WHERE `NAN`=?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            die("Errorea: " . mysqli_error($conn)); //Hau log-ean sartu beharko da.
        }
        mysqli_stmt_bind_param($stmt, "ssssss", $izab, $nan, $tlf, $jd, $mail, $_SESSION['ERAB']['NAN']);
    
    }

    //update-aren eskaera idazten dugu
   
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['ERAB']['izena'] = $izab;
        $toLog = $_SESSION['ERAB']['NAN'] . " erabiltzailea bere datuak aldatu ditu";
        require_once 'logger.php';
        eventLogger($toLog);
        header("Location: /datuakaldatu.php");
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
    <script src="./register.js"></script>
</head>

<body>
    <header class="top-bar">
        <div class="barra">
            <a href="index.php"><img class="logo" src="./source/bag.png" alt="Logo Alt Text"></a>
            <nav class="nav_barra">
                <ul>
                    <?php if (isset($_SESSION['ERAB'])) { ?>
                        <li class="li_barra"><a href="item_gehitu.php">Kamiseta gehitu</a></li>
                        <li class="li_barra"><a href="datuakaldatu.php">Datuak aldatu</a></li>
                        <li class="li_barra">
                            <form method="POST" class="logout_botoia">
                                <button class="btn btn-danger" name="logout">Logout</button>
                            </form>
                        </li>
                    <?php } else { ?>
                        <li class="li_barra"><a href="login.php">Log in</a></li>
                        <li class="li_barra"><a href="register.php">Register</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="gorputza">
        <div class="wrapper">
            <?php if (isset($_SESSION['ERAB'])) { ?>
                <form action="datuakaldatu.php" class="formularioa" method="POST" onsubmit="return datuakAldatuBaieztatu();">
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
                        <input type="text" value="<?php echo $nan; ?>" name="NAN" id="NAN" required readonly>
                    </div>
                    <div class="azalpen-test">
                        Telefono zenbakia
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $tlf; ?>" name="tlf" id="tlf" required>
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
                        Pasahitza (idatzi berri bat aurrekoa aldatzeko)
                    </div>
                    <div class="input-box">
                        <input type="password" value="" name="pass" id="pass">
                    </div>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
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