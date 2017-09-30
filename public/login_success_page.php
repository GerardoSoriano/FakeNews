<?php
SESSION_START();
include("conexionBD.php");
$connection = conectarBD();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Accediendo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="8, URL='index.php'">
</head>
<body>
	<br>
	<br>
	<?php
	$campoEmail = $_POST['txtEmail'];
	$campoPassword = $_POST['txtPassword'];
	$campoPassword = md5($campoPassword);

	$querySelect = "CALL obtenerDatosLogin(
	'$campoEmail',
	'$campoPassword')";

	$resultQuery = mysqli_query($connection, $querySelect) or die ("No se pudo iniciar sesión. Intentélo más tarde.");
	mysqli_close($connection);
	if ($resultQuery->num_rows) {
		$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
		foreach ($rows as $row) {
			echo "Bienvenido ".$row['nombre'], ' ', $row['apellidos'];
			$_SESSION['idULog']=$row['idUsuario'];
			$_SESSION['nombreULog']=$row['nombre'];
			$_SESSION['apellidosULog']=$row['apellidos'];
			$_SESSION['correoULog']=$row['correo'];
			$_SESSION['tipoULog']=$row['tipoUsuario'];
			$_SESSION['imgAvatarULog']=$row['imgAvatar'];
		}
	}
	echo "<br><br>Haz iniciado sesión exitosamente. Redirigiendose a";
	?>
	<a href="index.php">feiknews.com</a>
</body>
</html>