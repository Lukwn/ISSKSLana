<?php
include "konexioa.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kode hau bakarrik egikaritzen da register.js script-a ez badu false bueltatzen
    $izab = $_POST['izab'];
    $nan = $_POST['NAN'];
    $tlf = $_POST['tlf'];
    $jd = $_POST['jd'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM ERABILTZAILE WHERE NAN = '$nan'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // kontsultaren lerro emaitz kopurua kontatzen dira, 0 baino handiagoa bada erabiltzailea dagoela esan nahi du eta saioa hasiko da.
        $num_lerro = mysqli_num_rows($query);
        if ($num_lerro == 0) {
            // Datu basearen eskaera prestatzen dugu
            $sql = "INSERT INTO `ERABILTZAILE` (`Izen_Abizenak`, `NAN`, `Telefonoa`, `Jaiotze_data`, `email`, `pasahitza`) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $izab, $nan, $tlf, $jd, $mail, $pass);

            // Eskaera egikaritzen da eta ez badago errorerik orrialde nagusira joaten gara
            if (mysqli_stmt_execute($stmt)) {
                // Erregistratu da
                echo '<script>alert("Erregistratu da")</script>';

            } else {
                echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
            }

            mysqli_close($conn);
        } else {
            echo '<script>alert("NAN hori duen erabiltzailea badago")</script>';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="forms.css">
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
                    <li class="li_barra"><a href="item_gehitu.php">Kamiseta gehitu</a></li>
                    <?php if (isset($_SESSION['ERAB'])) { ?>
                        <li class="li_barra"><a href="datuakaldatu.php">Datuak aldatu</a></li>
                        <li class="li_barra">
                            <form method="POST" class="logout_botoia">
                                <button class="btn btn-danger" name="logout">Logout</button>
                            </form>
                        </li>
                    <?php } else { ?>
                        <li class="li_barra"><a href="login.php">Log in</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="gorputza">
        <div class="wrapper">
            <form action="register.php" class="formularioa" method="POST" onsubmit="return erregistroaBaieztatu();">
                <h1>Register</h1>
                <div class="input-box">
                    <input type="text" placeholder="Izen-Abizenak" name="izab" id="izab" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="NAN, eg: 11111111Z" name="NAN" id="NAN" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Telefonoa, 9 zenbaki" name="tlf" id="tlf" required>
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
                </div>
                <button type="submit" class="btn">Erregistratu</button>
                <div class="register-link">
                    <p>Jadanik kontu bat duzu?<a href="./login.php">Saioa hasi</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>