<?php
//Saioa hasi
session_start();

//mysqli-rekin konexioa ezarri
include "./konexioa.php";
include "./logout.php";

//Request-a egiten den momentuan egikaritzen da
if (isset($_REQUEST['login'])) {
    //nan eta pass aldagaiak lortzen ditugu.
    $nan = $_REQUEST['NAN'];
    $pass = $_REQUEST['pass'];
    //sql kontsulta gordetzen dugu aldagai batean eta gero egiten dugu mysqli_query() erabiliz
    $sql = "SELECT * FROM ERABILTZAILE WHERE NAN = '$nan'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        //kontsultaren lerro emaitz kopurua kontatzen dira, 0 baino handiagoa bada erabiltzailea dagoela esan nahi du eta saioa hasiko da.
        $num_lerro = mysqli_num_rows($query);
        if ($num_lerro > 0) {
            //kontsultaren lerroa zutabeen emaitzak gordetzen ditugu array batean, errezago atxitzeko
            $lerroa = mysqli_fetch_assoc($query);
            if ($pass == $lerroa['pasahitza']) {
                //saioa sortzen dugu
                $_SESSION['ERAB'] = array();
                $_SESSION['ERAB']['izena'] = $lerroa['Izen_Abizenak'];
                $_SESSION['ERAB']['NAN'] = $lerroa['NAN'];
                header("Location:./datuakaldatu.php");
                exit();
            } else {
                echo '<script>alert("Pasahitza ez da zuzena!")</script>';
            }
        } else {
            echo '<script>alert("Ez dago NAN hori duen erabiltzailerik.")</script>';
        }
    } else {
        echo '<script>alert("Errore bat egon da datu basea atzitzean.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="forms.css">
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
            <form class="formularioa" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="Erabiltzailea(NAN)" name="NAN" id="NAN" required>
                    <i class='bx bx-user-circle'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Pasahitza" name="pass" id="pass" required>
                    <i class='bx bx-lock-alt'></i>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
                <div class="register-link">
                    <p>Ez zaude erregistratuta? <a href="./register.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>