<?php
session_start();
include "setHeader.php";
include "konexioa.php";
require_once "CSFR.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
		$recaptcha_secret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'; // Replace with your actual secret key
		$recaptcha_response = $_POST['g-recaptcha-response'];

		// Verify the reCAPTCHA response
		$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
		$recaptcha_data = [
			'secret' => $recaptcha_secret,
			'response' => $recaptcha_response,
		];

		$options = [
			'http' => [
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'method' => 'POST',
				'content' => http_build_query($recaptcha_data),
			],
		];

		$context = stream_context_create($options);
		$recaptcha_result = file_get_contents($recaptcha_url, false, $context);
		$recaptcha_result = json_decode($recaptcha_result, true);

		if ($recaptcha_result['success']) {
			// Kode hau bakarrik egikaritzen da register.js script-a ez badu false bueltatzen
			$anticsrf = filter_input(INPUT_POST, 'anticsrf', FILTER_SANITIZE_STRING);
			tokenEgiaztatu($anticsrf);
			$izab = $_POST['izab'];
			$nan = $_POST['NAN'];
			$tlf = $_POST['tlf'];
			$jd = $_POST['jd'];
			$mail = $_POST['mail'];
			$pass = $_POST['pass'];

			$sql = "SELECT * FROM ERABILTZAILE WHERE NAN = ?";
			$stmt = mysqli_prepare($conn, $sql);
			if ($stmt === false) {
				die("Errorea: " . mysqli_error($conn)); //Hau log-ean sartu beharko da.
			}
			mysqli_stmt_bind_param($stmt, "s", $nan);
			mysqli_stmt_execute($stmt);
			$query = mysqli_stmt_get_result($stmt);

			if ($query) {
				// kontsultaren lerro emaitz kopurua kontatzen dira, 0 baino handiagoa bada erabiltzailea jadanik datu basean dagoela esan nahi du eta erregisterra ez da egingo.
				$num_lerro = mysqli_num_rows($query);
				if ($num_lerro == 0) {

					//gatza sortu “16 byte”
					$salt = bin2hex(random_bytes(16));

					//pasahitza eta gatza batu
					$passSalt = $pass . $salt;

					//hash-a sortu
					$hashedPassword = password_hash($passSalt, PASSWORD_DEFAULT);

					// Datu basearen eskaera prestatzen dugu
					$sql = "INSERT INTO `ERABILTZAILE` (`Izen_Abizenak`, `NAN`, `Telefonoa`, `Jaiotze_data`, `email`, `pasahitza`, `salt`) VALUES (?, ?, ?, ?, ?, ?, ?)";

					$stmt = mysqli_prepare($conn, $sql);
					if ($stmt === false) {
						die("Errorea: " . mysqli_error($conn)); //Hau log-ean sartu beharko da.
					}
					mysqli_stmt_bind_param($stmt, "sssssss", $izab, $nan, $tlf, $jd, $mail, $hashedPassword, $salt);

					// Eskaera egikaritzen da eta ez badago errorerik orrialde nagusira joaten gara
					if (mysqli_stmt_execute($stmt)) {
						// Erregistratu da
						$toLog = "Erabiltzaile erregistratua - " . $nan;
						require_once 'logger.php';
						eventLogger($toLog);
						echo '<script>alert("Erregistratu da")</script>';
					} else {
						echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
					}

					mysqli_close($conn);
				} else {
					echo '<script>alert("NAN hori duen erabiltzailea badago")</script>';
				}
			}
			// Reset the CAPTCHA token
			unset($_SESSION['token']);
		} else {
			// CAPTCHA verification failed, handle accordingly
			$error_message = 'Errore bat egon da.';
		}
	} else {
		// CAPTCHA was not completed, handle accordingly
		$error_message = 'CAPTCHA bete behar duzu.';
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
	<script src="./register.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
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
					<input type="text" placeholder="Mail, eg: adibidea@zerbitzaria.extentsioa" name="mail" id="mail" required>
				</div>
				<div class="input-box">
					<input type="password" placeholder="Pasahitza" name="pass" id="pass" required>
				</div>
				<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'] ?? '' ?>">
				<div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
				<button type="submit" class="btn">Erregistratu</button>
				<?php
				if (!empty($error_message)) {
					echo '<div class="register-link">' . $error_message . '</div>';
				}
				?>
				<div class="register-link">
					<p>Jadanik kontu bat duzu?<a href="./login.php">Saioa hasi</a></p>
				</div>
			</form>
		</div>
	</div>
</body>

</html>