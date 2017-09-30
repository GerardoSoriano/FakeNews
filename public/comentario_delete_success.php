<?php
SESSION_START();
include("conexionBD.php");
$connection = conectarBD();
$idComen = (int) $_GET['idComen'];
$idNoti = (int) $_GET['idNoti'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Eliminando comentario</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="6, URL='noticiaDetalle.php?id=<?php echo $idNoti;?>'">
</head>
<body>
	<br>
	<br>
	<?php
	$queryComen = "CALL deleteComentario('$idComen')";
	$resultQuery = mysqli_query($connection, $queryComen) or die (mysqli_error($connection));
	mysqli_close($connection);
	echo "<br>Se eliminó el comentario exitosamente. Redirigiendose a ";
	?>
	<a href="noticiaDetalle.php?id=<?php echo $idNoti; ?>">Noticia detalle</a>
</body>
</html>