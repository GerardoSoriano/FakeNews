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
	$campoTitulo = $_POST['txtTitulo'];
	$campoIdSeccion = $_POST['txtSeccion'];
	$campoDescripcion = $_POST['txtDescripcion'];
	$campoAutor = $_POST['txtAutor'];
	$campoTextoCompleto = $_POST['txtTextoCompleto'];
	$campoIsPublica = 0;
	$campoIsEspecial = (int) $_POST['txtIsEspecial'];
	$campoCintillo = $_POST['txtCintillo'];

	$querySeccion = "CALL obtenerSeccionById($campoIdSeccion)";
	$resultQuery = mysqli_query($connection, $querySeccion) or die ("Hubo un error al consultar la base de datos");

	if ($resultQuery->num_rows) {
		$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
		foreach ($rows as $row) {
			$campoSeccion = $row['nombreSeccion'];
		}
		mysqli_next_result($connection);
		$queryInsert = "CALL insertNoticia(
			'$campoTitulo',
			'$campoDescripcion',
			'$campoTextoCompleto',
			'$campoIdSeccion',
			'$campoSeccion',
			'$campoIdUsuario',
			'$campoAutor',
			'$campoIsPublica',
			'$campoIsEspecial',
			'$campoCintillo')";

$resultQueryInsert = mysqli_query($connection, $queryInsert) or die (mysqli_error($connection));
mysqli_close($connection);
}
echo "<br>Se añadió noticia exitosamente, en espera de ser aprobada. Redirigiendose a ";
?>
<a href="panelNoticia.php">Panel de noticias</a>
</body>
</html>