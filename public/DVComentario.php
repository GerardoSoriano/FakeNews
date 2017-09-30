<?php
class DVComentario {
	var $idComentario;
	var $nombreUsuario;
	var $textoComentario;
	var $fecha;
	var $idUsuario;
	var $urlMediaAvatar;

	function __construct($idComentario, $nombreUsuario, $idUsuario, $urlMediaAvatar, $textoComentario, $fecha) {
		$this -> idComentario = $idComentario;
		$this -> nombreUsuario = $nombreUsuario;
		$this -> idUsuario = $idUsuario;
		$this -> urlMediaAvatar = $urlMediaAvatar;
		$this -> textoComentario = $textoComentario;
		$this -> fecha = $fecha;
	}
}
?>