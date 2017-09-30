<?php
SESSION_START();
include("conexionBD.php");
$connection = conectarBD();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Subiendo noticia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="6, URL='panelNoticia.php'">
</head>
<body>
	<br>
	<br>
	<?php
	$campoIdUsuario = $_SESSION['idULog'];
	$campoTitulo = $_POST['txtTituloSecc'];

	$querySeccion = "CALL insertSeccion('$campoTitulo', '$campoIdUsuario')";
	$resultQuery = mysqli_query($connection, $querySeccion) or die (mysqli_error($connection));
	mysqli_close($connection);
	echo "<br>Se agregó seccion exitosamente. Redirigiendose a ";
	?>
	<a href="panelNoticia.php">Panel de noticias</a>
</body>
</html>