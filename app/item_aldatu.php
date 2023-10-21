<?php
session_start();

include "konexioa.php";
include "logout.php";

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
}

if (isset($_POST['submit'])) {
    //js-a ez badu false bueltatzen hurrengo kodea egikaritzen da, non  insert-aren balioak atxitzen dira formulariotik
    $izena = $_POST['izena'];
    $neurria = $_POST['neurria'];
    $prezioa = $_POST['prezioa'];
    $kolorea = $_POST['kolorea'];
    $marka = $_POST['marka'];

    //4. errorea ez dugu kontuan fitxategirik igo ez dela esan nahi duelako
    if ($_FILES['fitxategia']['error'] !== 4) {
        //Error 0 bada irudia igotzean errorik ez dela egon esan nahi du, beraz, irudia igotzen da.
        if ($_FILES['fitxategia']['error'] === 0) {
            $target_dir = "/var/www/html/img/";
            $target_file = $target_dir . basename($_FILES["fitxategia"]["name"]);

            if (move_uploaded_file($_FILES["fitxategia"]["tmp_name"], $target_file)) {
                $img = "img/" . $_FILES["fitxategia"]["name"];
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File upload error: " . $_FILES['fitxategia']['error'];
        }
    }


    //update-aren eskaera idazten dugu
    $sql = "UPDATE `OBJEKTUA` SET `izena`='$izena', `neurria`='$neurria', `prezioa`=$prezioa, `kolorea`='$kolorea', `marka`='$marka', `img`='$img' WHERE `id`=$id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location:./index.php");
    } else {
        echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
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
</head>

<body>
    <header class="top-bar">
        <div class="barra">
            <a href="index.php"><img class="logo" src="./img/bag.png" alt="Logo Alt Text"></a>
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
                        <li class="li_barra"><a href="register.php">Register</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="gorputza">
        <div class="wrapper">
            <form class="formularioa" method="POST" enctype="multipart/form-data">
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
                    <input type="number" value="<?php echo $prezioa; ?>" name="prezioa" id="prezioa" required>
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
                <div class="upload">
                    <input type="file" name="fitxategia" id="fitxategia">
                </div>
                <button type="submit" class="btn" name="submit">Aldatu</button>
            </form>
        </div>
    </div>

</body>

</html>