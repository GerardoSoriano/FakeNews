<?php
class DVSeccion {
	var $idSeccion;
	var $nombreSeccion;
	var $idUsuario;

	function __construct($idSeccion, $nombreSeccion, $idUsuario) {
		$this -> idSeccion = $idSeccion;
		$this -> nombreSeccion = $nombreSeccion;
		$this -> idUsuario = $idUsuario;
	}
}
?>