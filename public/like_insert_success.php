<?php
include("conexionBD.php");
$connection = conectarBD();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Subir contenido</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="0, URL='index.php'">
</head>
<body>
	<br>
	<br>
	<?php
	$txtIdUser = (int) $_POST['inpIdUsuario'];
	$txtIdNoti = (int) $_POST['inpIdNoticia'];
		$queryInsert = "CALL insertLike(
			'$txtIdUser',
			'$txtIdNoti')";
	$resultQuery = mysqli_query($connection, $queryInsert) or die (mysqli_error($connection));
	mysqli_close($connection);
	echo "<br><br>Redirigiendose a"; ?>
	<a href="index.php">feiknews.com</a>
</body>
</html>