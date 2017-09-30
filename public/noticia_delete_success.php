<?php
include("conexionBD.php");
$connection = conectarBD();
$idNoticia = (int) $_POST['txtIdNoticiaDelete'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Subir contenido</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="10, URL='editarNoticia.php?id=<?php echo $idNoticia; ?>'">
</head>
<body>
	<br>
	<br>
	<?php
	$queryDelete = "CALL deleteNoticia(
	'$idNoticia')";

	$resultQuery = mysqli_query($connection, $queryDelete) or die ("Hubo un error al insertar el registro");
	mysqli_close($connection);
	echo "Se eliminó noticia correctamente. Redirigiendose a";
	?>
	<a href="editarNoticia.php?id=<?php echo $idNoticia; ?>">Noticias pendientes de publicar</a>
</body>
</html>