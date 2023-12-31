<?php
include "setHeader.php";

//Sesioa hasi edo 
session_start();

include "konexioa.php";
include "logout.php";
require_once "CSFR.php";

if (isset($_SESSION['img']) || isset($_SESSION['id'])) {
	unset($_SESSION['img']);
	unset($_SESSION['id']);
}

$sql = "SELECT * FROM OBJEKTUA";
$produktuak = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta http-equiv="Content-Security-Policy" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Levin - Kamisetak</title>
	<link rel="stylesheet" href="lista.css">
	<link rel="stylesheet" href="barra.css">
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
	<section class="erdian">
		<!-- Datu baseko produktuak taulako elementu guztiak iteratzen dira eta web orrialdearen html kodean gehitzen dira-->
		<?php
		while ($row = mysqli_fetch_assoc($produktuak)) {
		?>
			<section class="productos">
				<article class="producto">
					<img src="<?php echo $row["img"] ?>" alt="">
					<h2>
						<?php echo $row["izena"] ?>
					</h2>
					<p>
						<?php echo $row["prezioa"] ?> €
					</p>
					<form action="item_aldatu.php" method="post">
						<input type="hidden" name="item_id" value="<?php echo $row["id"]; ?>">
						<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'] ?? '' ?>">
						<button type="submit">Datuak aldatu</button>
					</form>

					<form action="item_ezabatu.php" method="post">
						<input type="hidden" name="item_id" value="<?php echo $row["id"]; ?>">
						<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'] ?? '' ?>">
						<button type="submit">Ezabatu</button>
					</form>
				</article>
			</section>
		<?php
		}
		?>
	</section>

	<footer>
		<p>&copy; 2023 Levin Denda - Kamisetak</p>
	</footer>
</body>

</html>