<?php
class DVMultimedia {
	var $idMultimedia;
	var $idNoticia;
	var $urlMedia;
	var $tipoMedia;

	function __construct($idMultimedia, $idNoticia, $urlMedia, $tipoMedia) {
		$this -> idMultimedia = $idMultimedia;
		$this -> idNoticia = $idNoticia;
		$this -> urlMedia = $urlMedia;
		$this -> tipoMedia = $tipoMedia;
	}
}
?>