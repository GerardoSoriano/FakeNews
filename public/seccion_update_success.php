<?php
include("conexionBD.php");
$connection = conectarBD();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Actualizando noticia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="6, URL='panelNoticia.php'">
</head>
<body>
	<br>
	<br>
	<?php
	$IdSeccionUpdate = (int) $_POST['IdSeccionUpdate'];
	$campoTxtTitulo = $_POST['txtTitleSecUpdate'];

	$queryUpdate = "CALL updateSeccion(
			'$IdSeccionUpdate',
			'$campoTxtTitulo')";

$resultQueryInsert = mysqli_query($connection, $queryUpdate) or die (mysqli_error($connection));
mysqli_close($connection);

echo "<br>Se actualizó la sección exitosamente. Redirigiendose a ";
?>
<a href="panelNoticia.php">Subir noticia</a>
</body>
</html>