<?php
include("conexionBD.php");
$connection = conectarBD();
$txtIdNoticia = (int) $_POST['txtIdNoticia'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Subir contenido</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="5, URL='noticiaDetalle.php?id=<?php echo $txtIdNoticia; ?>'">
</head>
<body>
	<br>
	<br>
	<?php
	$campoNombre = $_POST['txtNombreUser'];
	$campoEmail = $_POST['txtEmailUser'];
	$textoUser = $_POST['txtTextoUser'];
	$txtIdUser = (int) $_POST['txtIdUser'];
	$txtIdCommentPapa = (int) $_POST['txtIdCommentPapa'];
	if ($textoUser != '' && $textoUser != ' ') {
		$queryInsert = "CALL insertComentario(
			'$textoUser',
			'$campoNombre',
			'$campoEmail',
			'$txtIdUser',
			'$txtIdNoticia',
			'$txtIdCommentPapa')";
	$resultQuery = mysqli_query($connection, $queryInsert) or die (mysqli_error($connection));
	mysqli_close($connection);
	echo "<br><br>Se añadió comentario exitosamente. Redirigiendose a"; ?>
	<a href="noticiaDetalle.php?id=<?php echo $txtIdNoticia; ?>">Noticia</a>
	<?php } else {
		echo "Por favor ingresa un texto válido e inténtelo de nuevo. Gracias!";
	} ?>
</body>
</html>