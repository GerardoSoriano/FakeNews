<?php
function conectarBD() {
	$conexion = mysqli_connect("localhost", "root", "", "basebdm");
	if (mysqli_connect_errno()) {
		echo 'Error al conectar la base de datos' . mysqli_connect_error();
	} else {
	}
	return $conexion;
}
?>