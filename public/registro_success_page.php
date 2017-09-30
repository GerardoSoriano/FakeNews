<?php
include("conexionBD.php");
$connection = conectarBD();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Subir contenido</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="10, URL='index.php'">
</head>
<body>
	<br>
	<br>
	<?php
	$campoNombre = $_POST['txtNombre'];
	$campoApellidos = $_POST['txtApellidos'];
	$campoEmail = $_POST['txtEmail'];
	$campoContrasenia = $_POST['txtPassword'];
	$campoNacDia = $_POST['txtNacDia'];
	$campoNacMes = $_POST['txtNacMes'];
	$campoNacAnio = $_POST['txtNacAnio'];
	$campoTelefono = $_POST['txtTelefono'];
	$campoTipoU = $_POST['txtTipoUsuario'];
	if ($campoTipoU == NULL) {
		$campoTipoU = 'Normal';
	}
	$campoNacimiento = $campoNacDia."-".$campoNacMes."-".$campoNacAnio;
	$campoContrasenia = md5($campoContrasenia);

	$queryInsert = "CALL insertUsuario(
	'$campoNombre',
	'$campoApellidos',
	'$campoEmail',
	'$campoContrasenia',
	'$campoTelefono',
	'$campoNacimiento',
	'$campoTipoU')";

	$resultQuery = mysqli_query($connection, $queryInsert) or die ("Hubo un error al insertar el registro");
	mysqli_close($connection);
	echo "Se añadió registro exitosamente. Redirigiendose a";
	?>
	<a href="registro_success_page.php">feiknews.com</a>
</body>
</html>