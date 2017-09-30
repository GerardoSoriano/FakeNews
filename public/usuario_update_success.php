<?php
include("conexionBD.php");
$connection = conectarBD();
$campoIdUsuario = (int) $_POST['txtIdUsuario'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Actualizando información del usuario</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="7, URL='perfil.php?id=<?php echo $campoIdUsuario; ?>'">
</head>
<body>
	<br>
	<br>
	<?php
	$campoTipoCuenta = $_POST['txtTipoCuenta'];
	$campoNombre = $_POST['txtNombre'];
	$campoApellidos = $_POST['txtApellidos'];
	$campoEmail = $_POST['txtEmail'];
	$campoPassword = $_POST['txtPassword'];
	$campoNacDia = $_POST['txtNacDia'];
	$campoNacMes = $_POST['txtNacMes'];
	$campoNacAnio = $_POST['txtNacAnio'];
	$campoTelefono = $_POST['txtTelefono'];
	$campoFechaNacimiento = $campoNacDia."-".$campoNacMes."-".$campoNacAnio;
	$campoFechaNacimiento = str_replace(" ", "", $campoFechaNacimiento);
	$campoAvatar = $_POST['txtImgAvatar'];
	$campoPortada = $_POST['txtImgPortada'];
	$nombreFileAvatar = $_FILES['inpImgPerfil']['name'];
	$nombreFilePortada = $_FILES['inpImgPortada']['name'];
	$campoPassword = md5($campoPassword);

	if ($nombreFileAvatar != NULL && $nombreFileAvatar != '') {
		$nomTmpAvatar = $_FILES['inpImgPerfil']['tmp_name'];
		$nomFile1 = substr($nombreFileAvatar, 0, strrpos($nombreFileAvatar, '.'));
		$ext1 = substr($nombreFileAvatar, strrpos($nombreFileAvatar, '.'));
		$nomAlt1 = $nomFile1.time().$ext1;
		$nomAlt1 = str_replace(" ", "_", $nomAlt1);
		if (move_uploaded_file($nomTmpAvatar, "images/profile/$nomAlt1")) {
			$campoAvatar = $nomAlt1;
			echo "Se movio imagen exitosamente!!! yeeeeey!!!----> ".$campoAvatar;
		} else {
			echo "NO se movio imagen exitosamente!!! uuuuuuhh!!!----> ";
		}
	} else {
		echo "No se hizo ningun movimiento----> ".$campoAvatar;
	}

	if ($nombreFilePortada != NULL && $nombreFilePortada != '') {
		$nomTmpPortada = $_FILES['inpImgPortada']['tmp_name'];
		$nomFile2 = substr($nombreFilePortada, 0, strrpos($nombreFilePortada, '.'));
		$ext2 = substr($nombreFilePortada, strrpos($nombreFilePortada, '.'));
		$nomAlt2 = $nomFile2.time().$ext2;
		$nomAlt2 = str_replace(" ", "_", $nomAlt2);
		if (move_uploaded_file($nomTmpPortada, "images/profile/$nomAlt2")) {
			$campoPortada = $nomAlt2;
			echo "Se movio imagen portada exitosamente!!! yeeeeey!!!----> ".$campoPortada;
		} else {
			echo "NO se movio imagen portada exitosamente!!! uuuuuuhh!!!----> ";
		}
	} else {
		echo "No se hizo ningun movimiento Portada----> ".$campoPortada;
	}

	$queryUpdate = "CALL updateUsuarioById(
		'$campoIdUsuario',
		'$campoNombre',
		'$campoApellidos',
		'$campoEmail',
		'$campoPassword',
		'$campoTelefono',
		'$campoFechaNacimiento',
		'$campoTipoCuenta',
		'$campoAvatar',
		'$campoPortada')";

$resultQueryInsert = mysqli_query($connection, $queryUpdate) or die (mysqli_error($connection));
mysqli_close($connection);

echo "<br>Se actualizó los datos de usuario exitosamente. Redirigiendose a ";
?>
<a href="perfil.php?id=<?php echo $campoIdUsuario; ?>">Perfil de <?php echo $campoNombre." ".$campoApellidos; ?></a>
</body>
</html>