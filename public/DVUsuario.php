<?php
class DVUsuario {
	var $idUsuario;
	var $nombre;
	var $apellidos;
	var $correo;
	var $contrasenia;
	var $telefono;
	var $fechaNacimiento;
	var $tipoUsuario;
	var $imgAvatar;
	var $imgPortada;

	function __construct($idUsuario, $nombre, $apellidos, $correo, $contrasenia, $telefono, 
		$fechaNacimiento, $tipoUsuario, $imgAvatar, $imgPortada) {
		$this -> idUsuario = $idUsuario;
		$this -> nombre = $nombre;
		$this -> apellidos = $apellidos;
		$this -> correo = $correo;
		$this -> contrasenia = $contrasenia;
		$this -> telefono = $telefono;
		$this -> fechaNacimiento = $fechaNacimiento;
		$this -> tipoUsuario = $tipoUsuario;
		$this -> imgAvatar = $imgAvatar;
		$this -> imgPortada = $imgPortada;
	}
}
?>