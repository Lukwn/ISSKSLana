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

?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zure datuak</title>
    <link rel="stylesheet" href="datuakaldatu.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
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
                    <i class='bx bx-user-circle'></i>
                </div>
                <div class="azalpen-test">
                    NAN-a
                </div>
                <div class="input-box">
                    <input type="text" value="<?php echo $nan; ?>"name="NAN" id="NAN" required>
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
                    <input type="text" value="<?php echo $mail; ?>" name="mail" id="mail"
                        required>
                </div>
                <div class="azalpen-test">
                    Pasahitza
                </div>
                <div class="input-box">
                    <input type="text" value="<?php echo $pass; ?>" name="pass" id="pass" required>
                    <i class='bx bx-lock-alt'></i>
                </div>
                <button type="submit" class="btn">Aldatu</button>
            </form>
        <?php } else { ?>
            <h1>Saioa hasi behar duzu orrialde hau erabiltzeko</h1>
            <button onclick="window.location.href = 'login.php'" class="btn">Saioa hasi</button>
        <?php } ?>
    </div>
</body>

</html>