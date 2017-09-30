<?php
include("conexionBD.php");
$connection = conectarBD();
$campoIdNoticia = (int) $_POST['txtIdNoticia'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Actualizando noticia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="6, URL='editarNoticia.php?id=<?php echo $campoIdNoticia; ?>'">
</head>
<body>
	<br>
	<br>
	<?php
	$campoIsPublica = (int) $_POST['txtValidacion'];
	$campoTitulo = $_POST['txtTitulo'];
	$campoIdSeccion = (int) $_POST['txtIdSeccion'];
	$campoSeccion = $_POST['txtSeccion'];
	$campoDescripcion = $_POST['txtDescripcion'];
	$campoAutor = $_POST['txtAutor'];
	$campoIdAutor = (int) $_POST['txtIdAutor'];
	$campoTextoCompleto = $_POST['txtTextoCompleto'];

	$queryUpdate = "CALL updateNoticia(
			'$campoIdNoticia',
			'$campoTitulo',
			'$campoDescripcion',
			'$campoTextoCompleto',
			'$campoIdSeccion',
			'$campoSeccion',
			'$campoIdAutor',
			'$campoAutor',
			'$campoIsPublica')";

$resultQueryInsert = mysqli_query($connection, $queryUpdate) or die (mysqli_error($connection));
mysqli_close($connection);

echo "<br>Se actualizó la noticia exitosamente, en espera de ser aprobada. Redirigiendose a ";
?>
<a href="editarNoticia.php?id=<?php echo $campoIdNoticia; ?>">Editar noticia</a>
</body>
</html>