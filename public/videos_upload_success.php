<?php
error_reporting(0);
include("conexionBD.php");
$connection = conectarBD();
$campoIdNoti = (int) $_POST['txtIdNoticiaMedia'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Actualizando información</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="7, URL='editarNoticia.php?id=<?php echo $campoIdNoti; ?>'">
</head>
<body>
	<br>
	<br>
	<?php
	$idMedia1 = $_POST['inpIdMediaVid01'];
	$idMedia2 = $_POST['inpIdMediaVid02'];
	$idMedia3 = $_POST['inpIdMediaVid03'];

	$nombreArchivo1 = $_FILES['inpVidNoti01']['name'];
	$nombreArchivo2 = $_FILES['inpVidNoti02']['name'];
	$nombreArchivo3 = $_FILES['inpVidNoti03']['name'];

	echo $nombreArchivo1;

	if ($nombreArchivo1 != NULL && $nombreArchivo1 != '') {
		$nomTmpArchivo1 = $_FILES['inpVidNoti01']['tmp_name'];
		$nomFile1 = substr($nombreArchivo1, 0, strrpos($nombreArchivo1, '.'));
		$ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
		$nomAlt1 = $nomFile1.time().$ext1;
		$nomAlt1 = str_replace(" ", "_", $nomAlt1);
		echo $nomAlt1;
		if (move_uploaded_file($nomTmpArchivo1, "videos/$nomAlt1")) {		
			$queryInsert1 = "CALL updateMultimediaById(
				'$idMedia1',
				'$campoIdNoti',
				'$nomAlt1',
				'1')";
			$resultQueryInsert = mysqli_query($connection, $queryInsert1) or die (mysqli_error($connection));
			mysqli_next_result($connection);
			echo "<br>Se subió archivo ".$nombreArchivo1." exitosamente";
			} else {
				echo "<br>NO se subió archivo exitosamente";
			}
		}

if ($nombreArchivo2 != NULL && $nombreArchivo2 != '') {
	$nomTmpArchivo2 = $_FILES['inpVidNoti02']['tmp_name'];
	$nomFile2 = substr($nombreArchivo2, 0, strrpos($nombreArchivo2, '.'));
	$ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
	$nomAlt2 = $nomFile2.time().$ext2;
	$nomAlt2 = str_replace(" ", "_", $nomAlt2);
	if (move_uploaded_file($nomTmpArchivo2, "videos/$nomAlt2")) {
		$queryInsert2 = "CALL updateMultimediaById(
				'$idMedia2',
				'$campoIdNoti',
				'$nomAlt2',
				'1')";
$resultQueryInsert = mysqli_query($connection, $queryInsert2) or die (mysqli_error($connection));
mysqli_next_result($connection);
echo "<br>Se subió archivo ".$nombreArchivo2." exitosamente";
	} else {
		echo "NO se subió archivo exitosamente";
	}
}

if ($nombreArchivo3 != NULL && $nombreArchivo3 != '') {
	$nomTmpArchivo3 = $_FILES['inpVidNoti03']['tmp_name'];
	$nomFile3 = substr($nombreArchivo3, 0, strrpos($nombreArchivo3, '.'));
	$ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
	$nomAlt3 = $nomFile3.time().$ext3;
	$nomAlt3 = str_replace(" ", "_", $nomAlt3);
	if (move_uploaded_file($nomTmpArchivo3, "videos/$nomAlt3")) {
		$queryInsert3 = "CALL updateMultimediaById(
				'$idMedia3',
				'$campoIdNoti',
				'$nomAlt3',
				'1')";
$resultQueryInsert = mysqli_query($connection, $queryInsert3) or die (mysqli_error($connection));
		echo "<br>Se subió archivo ".$nombreArchivo3." exitosamente";
	} else {
		echo "NO se subió archivo exitosamente";
	}
}

mysqli_close($connection);

echo "<br>Se actualizó la noticia exitosamente. Redirigiendose a ";
?>
<a href="editarNoticia.php?id=<?php echo $campoIdNoti; ?>">Editar noticia</a>
</body>
</html>