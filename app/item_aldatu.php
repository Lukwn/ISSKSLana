<?php
session_start();
include "setHeader.php";

include "konexioa.php";
include "logout.php";
require_once "CSFR.php";


//Sesioaren superglobalean sartzen ditugu id-a eta irudiaren izena geroago izateko
if (!isset($_SESSION['img']) || !isset($_SESSION['id'])) {
    $id = $_POST['item_id'];
    $_SESSION['id'] = $id;

    $sql = "SELECT * FROM OBJEKTUA WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $lerroa = mysqli_fetch_assoc($query);
        $_SESSION['img'] = $lerroa['img'];
    }
} else {
    $id = $_SESSION['id'];
    $img = $_SESSION['img'];
}

$sql = "SELECT * FROM OBJEKTUA WHERE id = '$id'";
$query = mysqli_query($conn, $sql);
if ($query) {
    //kontsultaren lerroa zutabeen emaitzak gordetzen ditugu array batean, errezago atxitzeko
    $lerroa = mysqli_fetch_assoc($query);
    $izena = $lerroa['izena'];
    $neurria = $lerroa['neurria'];
    $prezioa = $lerroa['prezioa'];
    $kolorea = $lerroa['kolorea'];
    $marka = $lerroa['marka'];
    $erab = $lerroa['erab'];
}

if (isset($_POST['submit'])) {
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
	tokenEgiaztatu($token);
    if (isset($_SESSION['ERAB']) && $_SESSION['ERAB']['NAN'] == $erab) {
        //js-a ez badu false bueltatzen hurrengo kodea egikaritzen da, non  insert-aren balioak atxitzen dira formulariotik
        $izena = $_POST['izena'];
        $neurria = $_POST['neurria'];
        $prezioa = $_POST['prezio'];
        $kolorea = $_POST['kolorea'];
        $marka = $_POST['marka'];

        //4. errorea ez dugu kontuan fitxategirik igo ez dela esan nahi duelako
        if ($_FILES['fitxategia']['error'] !== 4) {
            //Error 0 bada irudia igotzean errorik ez dela egon esan nahi du, beraz, irudia igotzen da.
            if ($_FILES['fitxategia']['error'] === 0) {
                $target_dir = "/var/www/html/img/";
                $target_file = $target_dir . basename($_FILES["fitxategia"]["name"]);
                if (!file_exists($target_file)) {
                    if (move_uploaded_file($_FILES["fitxategia"]["tmp_name"], $target_file)) {
                    } else {
                        echo "Errore bat egon da argazkia igotzerakoan.";
                    }
                }
            } else {
                echo "File upload error: " . $_FILES['fitxategia']['error'];
            }
            $img = "img/" . $_FILES["fitxategia"]["name"];
        }
        //update-aren eskaera idazten dugu
        $sql = "UPDATE `OBJEKTUA` SET `izena`=?, `neurria`=?, `prezioa`=?, `kolorea`=?, `marka`=?, `img`=? WHERE `id`=?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            die("Errorea: " . mysqli_error($conn)); //Hau log-ean sartu beharko da.
        }
        mysqli_stmt_bind_param($stmt, "ssdssss", $izena, $neurria, $prezioa, $kolorea, $marka, $img, $id);
        if (mysqli_stmt_execute($stmt)) {
            $toLog = $_SESSION['ERAB']['NAN'] . " erabiltzailea " . $id . " kamiseta aldatu du";
            require_once 'logger.php';
            eventLogger($toLog);
            header("Location:./index.php");
        } else {
            echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
        }
    } else {
        echo '<script>alert("Errore bat egon da.")</script>';
    }
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

                <form action="item_aldatu.php" class="formularioa" method="POST" enctype="multipart/form-data" onsubmit="return prezioZenbakia();">
                    <h1>
                        <?php echo $izena ?>
                        kamisetaren datuak aldatu.
                    </h1>
                    <div class="azalpen-test">
                        Izena
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $izena; ?>" name="izena" id="izena" required>
                    </div>
                    <div class="azalpen-test">
                        Neurria
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $neurria; ?>" name="neurria" id="neurria" required>
                    </div>
                    <div class="azalpen-test">
                        Prezioa
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $prezioa; ?>" name="prezio" id="prezio" required>
                    </div>
                    <div class="azalpen-test">
                        Kolorea
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $kolorea; ?>" name="kolorea" id="kolorea" required>
                    </div>
                    <div class="azalpen-test">
                        Marka
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php echo $marka; ?>" name="marka" id="marka" required>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                    <div class="upload">
                        <input type="file" name="fitxategia" id="fitxategia">
                    </div>
                    <button type="submit" class="btn" name="submit">Aldatu</button>
                </form>
            <?php } else { ?>
                <h1>Saioa hasi behar duzu kamisetaren datuak aldatzeko.</h1>
                <button onclick="window.location.href = 'login.php'" class="btn">Saioa hasi</button>
            <?php } ?>
        </div>
    </div>

</body>

</html>