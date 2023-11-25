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
	//sql kontsulta gordetze	n dugu aldagai batean eta gero egiten dugu mysqli_query() erabiliz
	$sql = "SELECT * FROM ERABILTZAILE WHERE NAN = ?";
	$stmt = mysqli_prepare($conn, $sql);
	if ($stmt === false) {
		die("Errorea: " . mysqli_error($conn)); //Hau log-ean sartu beharko da.
	}
	mysqli_stmt_bind_param($stmt, "s", $nan);
	mysqli_stmt_execute($stmt);
	$query = mysqli_stmt_get_result($stmt);

	if ($query) {
    	//kontsultaren lerro emaitz kopurua kontatzen dira, 0 baino handiagoa bada erabiltzailea dagoela esan nahi du eta saioa hasiko da.
    	$num_lerro = mysqli_num_rows($query);
    	if ($num_lerro > 0) {
        	//kontsultaren lerroa zutabeen emaitzak gordetzen ditugu array batean, errezago atxitzeko
        	$lerroa = mysqli_fetch_assoc($query);
       	 
        	//salt gorde
        	$salt = $lerroa['salt'];
       	 
        	//pasahitza biderkatu salt-ekin
        	$passSalt = $pass.$salt;
       	 
        	//gordetako pasahitza gorde
        	$storedPasswordHash = $lerroa['pasahitza'];
       	 
        	//emaitza gordetako gakoarekin konparatu
        	if (password_verify($passSalt, $storedPasswordHash)) {
            	//saioa sortzen dugu
            	$_SESSION['ERAB'] = array();
            	$_SESSION['ERAB']['izena'] = $lerroa['Izen_Abizenak'];
            	$_SESSION['ERAB']['NAN'] = $lerroa['NAN'];

				/*$archivoLog = 'actions.log';
				$ipAddress = $_SERVER['REMOTE_ADDR'];
				$toLog = "Intento de log in from IP $ipAddress - " . $lerroa['NAN'] . " " . $pass;
				$archivo = fopen($archivoLog, 'a');
				$fechaHora = date('Y-m-d H:i:s');
				$mensajeLog = "[$fechaHora] $toLog\n";  // Use $toLog instead of $mensaje
				fwrite($archivo, $mensajeLog);
				fclose($archivo);*/

            	header("Location:./datuakaldatu.php");
            	exit();
        	} else {
            	echo '<script>alert("NAN-a edo pasahitza ez dira egokiak.")</script>';
        	}
    	} else {
        	echo '<script>alert("NAN-a edo pasahitza ez dira egokiak.")</script>';
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
	<title>Login</title>
	<link rel="stylesheet" href="forms.css">
	<link rel="stylesheet" href="./barra.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

