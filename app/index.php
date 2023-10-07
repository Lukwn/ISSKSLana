<?php
session_start();

include "./konexioa.php";
include "./logout.php";

if (isset($_REQUEST['login'])) {
    $nan = $_REQUEST['NAN'];
    $pass = $_REQUEST['pass'];
    $sql = "SELECT * FROM ERABILTZAILE WHERE NAN = '$nan'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $num_lerro = mysqli_num_rows($query);
        if ($num_lerro > 0) {
            $lerroa = mysqli_fetch_assoc($query);
            if ($pass == $lerroa['pasahitza']) {
                $_SESSION['NAN'] = $lerroa['nan'];
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
echo $_SESSION['NAN'];
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
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
</body>

</html>