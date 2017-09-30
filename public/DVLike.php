<?php
class DVLike {
	var $idLike;
	var $idNoticia;
	var $idUsuario;

	function __construct($idLike, $idNoticia, $idUsuario) {
		$this -> idLike = $idLike;
		$this -> idNoticia = $idNoticia;
		$this -> idUsuario = $idUsuario;
	}
}
?>