<?php
include "setHeader.php";

//Saioa hasi
session_start();

//mysqli-rekin konexioa ezarri
include "./konexioa.php";
include "./logout.php";
require_once "CSFR.php";

$ip = $_SERVER['REMOTE_ADDR'];

if (!isset($_SESSION['saiakeraKop'])) {
	$_SESSION['saiakeraKop'] = 0;
}

if (isIPBanned($ip)) {
	// IP baneatuta badago, index.php-ra buetatuko gara
	header("Location: ./index.php");
	exit();
} 

//Request-a egiten den momentuan egikaritzen da
if (isset($_REQUEST['login'])) {
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
			//CAPTCHA baieztatu da
			$anticsrf = filter_input(INPUT_POST, 'anticsrf', FILTER_SANITIZE_STRING);
			tokenEgiaztatu($anticsrf);

			//nan eta pass aldagaiak lortzen ditugu.
			$nan = $_REQUEST['NAN'];
			$pass = $_REQUEST['pass'];
			$ip = $_SERVER['REMOTE_ADDR'];

			//sql kontsulta gordetze	n dugu aldagai batean eta gero egiten dugu mysqli_query() erabiliz
			$sql = "SELECT * FROM ERABILTZAILE WHERE NAN = ?";
			$stmt = mysqli_prepare($conn, $sql);
			if ($stmt === false) {
				require_once 'logger.php';
				errorLogger("Errorea: " . mysqli_error($conn));
				die("Errore bat egon da");
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
					$passSalt = $pass . $salt;

					//gordetako pasahitza gorde
					$storedPasswordHash = $lerroa['pasahitza'];

					//emaitza gordetako gakoarekin konparatu
					if (password_verify($passSalt, $storedPasswordHash)) {
						//saioa sortzen dugu
						$_SESSION['ERAB'] = array();
						$_SESSION['ERAB']['izena'] = $lerroa['Izen_Abizenak'];
						$_SESSION['ERAB']['NAN'] = $lerroa['NAN'];
						$_SESSION['saiakeraKop'] = 0;

						//Meter Log
						$toLog = "Log in arrakastatsua - " . $lerroa['NAN'];
						require_once 'logger.php';
						eventLogger($toLog);

						header("Location:./datuakaldatu.php");
						exit();
					} else {
						echo '<script>alert("NAN-a edo pasahitza ez dira egokiak.")</script>';
						$toLog = "Log in saiakera ez arrakastatsua - " . $lerroa['NAN'] . " . Erabilitako pasahitza: " . $pass;
						require_once 'logger.php';
						eventLogger($toLog);
					}
				} else {
					echo '<script>alert("NAN-a edo pasahitza ez dira egokiak.")</script>';
					$toLog = "Log in saiakera ez arrakastatsua - " . $lerroa['NAN'] . " . Erabilitako pasahitza: " . $pass;
					require_once 'logger.php';
					eventLogger($toLog);
				}
			} else {
				echo '<script>alert("Errore bat egon da.")</script>';
			}
			//CAPTCHA token-a berrabiarazi
			unset($_SESSION['token']);

			$_SESSION['saiakeraKop']++; // Login saiakerak handitu

			if ($_SESSION['saiakeraKop'] >= 5) {
				//Saiakera gehiegi egon direnez, azken saiakera honetan saiakera asko egon direla esango digu eta index.php-ra bueltatuko gaitu
				//PHP-k ez du uzten header metodoaren aurretik echo bat egiten beraz JavaScript erabiliz egingo dugu
				echo '<script>';
				echo 'setTimeout(function(){';
				echo '  alert("Saiakera gehiegi: ' . $_SESSION['saiakeraKop'] . '");';
				echo '  window.location.href = "./index.php";';
				echo '}, 1000);'; // segundu bat itxaron
				echo '</script>';
				//$_SESSION['saiakeraKop'] = 0;


				//Gure ip-ak saiakera gehiegi izan dituela kontuan hartuko du eta gure ip-a baneatuta dauden ip-lista batera gehituko ditu
				banIP($ip);
				exit();
			}
		} else {
			// CAPTCHA huts egin du
			$error_message = 'Errore bat egon da.';
			+require_once 'logger.php';
			errorLogger("Captcha failed");
		}
	} else {
		// CAPTCHA ez da bete
		$error_message = 'CAPTCHA bete behar duzu.';
		+require_once 'logger.php';
		errorLogger("Captcha ez da bete");
	}
}
function banIP($ip)
{
    //Sartu den ip-a gorde baneatuen ip-listan
    $file = 'logs/banned_IP.txt';
    $data = "$ip|" . time() . "\n";
    file_put_contents($file, $data, FILE_APPEND);
}

function isIPBanned($ip)
{
    $file = 'logs/banned_IP.txt';
    $bannedIPs = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($bannedIPs as $line) {
        list($bannedIP, $timestamp) = explode('|', $line);
        if ($bannedIP === $ip) {
            // Begiratu ip-baneo denbora igaro den (2 min)
            $banDuration = 2 * 60; // 2 minutu segundutan
            if (time() - $timestamp < $banDuration) {
                return true; // ip baneatuta dago oraindik
            }
			else{
				$_SESSION['saiakeraKop'] = 0;
			}
        }
    }
    return false; // ip ez dago baneatuta
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
	<meta http-equiv="Content-Security-Policy" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="forms.css">
	<link rel="stylesheet" href="./barra.css">
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
			<form class="formularioa" method="POST">
				<h1>Login</h1>
				<div class="input-box">
					<input type="text" placeholder="Erabiltzailea(NAN)" name="NAN" id="NAN" required>
				</div>
				<div class="input-box">
					<input type="password" placeholder="Pasahitza" name="pass" id="pass" required>
				</div>
				<div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
				<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'] ?? '' ?>">
				<button type="submit" name="login" class="btn">Login</button>
				<?php
				if (!empty($error_message)) {
					echo '<div class="register-link">' . $error_message . '</div>';
				}
				?>
				<div class="register-link">
					<p>Ez zaude erregistratuta? <a href="./register.php">Register</a></p>
				</div>
			</form>
		</div>
	</div>
</body>

</html>