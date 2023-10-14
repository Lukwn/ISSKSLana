<?php
session_start();

include "konexioa.php";
include "logout.php";

$sql = "SELECT * FROM OBJEKTUA";
$produktuak = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tienda Levin - Camisetas</title>
	<link rel="stylesheet" href="lista.css"> <!-- Enlaza tu hoja de estilos CSS aquí -->
</head>

<body>
	<header>
		<h1>Levin</h1>
		<nav>
			<ul>
				<li><a href="#">Inicio</a></li>
				<li><a href="#">Catálogo</a></li>
				<li><a href="#">Contacto</a></li>
			</ul>
		</nav>
	</header>
	<section class="erdian">
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
						<button type="submit">Datuak aldatu</button>
					</form>

					<form action="item_ezabatu.php" method="post">
						<input type="hidden" name="item_id" value="<?php echo $row["id"]; ?>">
						<button type="submit">Ezabatu</button>
					</form>
				</article>
			</section>
			<?php
		}
		?>
	</section>

	<footer>
		<p>&copy; 2023 Tienda Levin - Camisetas</p>
	</footer>
</body>

</html>