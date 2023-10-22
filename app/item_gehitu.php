<?php
include "konexioa.php";


if (isset($_POST['submit'])) {
    $izena = $_POST['izena'];
    $neurria = $_POST['neurri'];
    $prezioa = $_POST['prezio'];
    $kolorea = $_POST['kolore'];
    $marka = $_POST['marka'];

    //Irudia igotzeko bidea aldagaietan gordetzen dira, erabilerrazak izateko
    $target_dir = "/var/www/html/img/";
    $target_file = $target_dir . basename($_FILES["fitxategia"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    //Erabiltzaileak igotako irudia igotzen da zerbitzariaren direktoriora
    if (move_uploaded_file($_FILES["fitxategia"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fitxategia"]["name"]) . " has been uploaded.";
    } else {
        echo "Errore bat egon da argazkia igotzerakoan.";
    }

    $img = "img/" . $_FILES["fitxategia"]["name"];

    //insert-a idazten dugu eta prestatzen dugu egikaritzeko
    $sql = "INSERT INTO `OBJEKTUA` (`izena`, `neurria`, `prezioa`, `kolorea`, `marka`, `img`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdsss", $izena, $neurria, $prezioa, $kolorea, $marka, $img);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Kamiseta igo da.")</script>';
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
    <title>Kamiseta igo</title>
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
            <form action="item_gehitu.php" class="formularioa" method="POST" enctype="multipart/form-data">
                <h1>Kamiseta igo</h1>
                <div class="input-box">
                    <input type="text" placeholder="Izena" name="izena" id="izena" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Neurria" name="neurri" id="neurri" required>
                </div>
                <div class="input-box">
                    <input type="number" placeholder="Prezioa" name="prezio" id="prezio" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Kolorea" name="kolore" id="kolore" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Marka" name="marka" id="marka" required>
                </div>
                <div class="azalpen-test">
                    Argazkia aukeratu:
                </div>
                <div class="upload">
                    <input type="file" name="fitxategia" id="fitxategia">
                </div>
                <button type="submit" name="submit" class="btn">Erregistratu</button>
            </form>
        </div>
    </div>
</body>

</html>