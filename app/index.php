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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <form class="formularioa">
            <h1>Aukeratu</h1>
            <input type="button" class="btn" onclick="window.location.href='register.php'" value="Erregistratu"></input>
            <input type="button" class="btn" onclick="window.location.href='login.php'" value="Login"></input>
            <input type="button" class="btn" onclick="window.location.href='datuakaldatu.php'"
                value="Datuak aldatu"></input>
        </form>
    </div>
</body>

</html>