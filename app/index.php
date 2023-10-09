<?php
session_start();
session_destroy();
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
            <a href="index.php"><img class="logo" src="./img/bag.png" alt="Logo Alt Text"></a>
            <nav class="nav_barra">
                <ul>
                    <li class="li_barra"><a href="login.php">Log in</a></li>
                    <li class="li_barra"><a href="register.php">Register</a></li>
                    <li class="li_barra"><a href="datuakaldatu.php">Datuak aldatu</a></li>
                    <li class="li_barra"><a href="#">Log out</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="gorputza">

        <div class="wrapper">
            <form class="formularioa">
                <h1>Aukeratu</h1>
                <input type="button" class="btn" onclick="window.location.href='register.php'"
                    value="Erregistratu"></input>
                <input type="button" class="btn" onclick="window.location.href='login.php'" value="Login"></input>
                <input type="button" class="btn" onclick="window.location.href='datuakaldatu.php'"
                    value="Datuak aldatu"></input>
            </form>
        </div>
    </div>

</body>

</html>