<?php
SESSION_START();
?>
<!DOCTYPE HTML>
<?  error_reporting(E_ALL); ?>
<html>
<head>
	<title>Header</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' type='text/css' href="css/mystyle.css" />
	<link href="css/bootstrap-3.1.1.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="header" id="home">
		<div class="content white">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="navbar-header">				
						<a class="navbar-brand" href="index.php"><h1><span>FEIK</span>NEWS</h1></a>
					</div>
					<!--/.header-->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<?php
							if (isset($_SESSION["tipoULog"])) {
								$idUser = $_SESSION['idULog'];
								$tipoUser = $_SESSION["tipoULog"];
								if (strcmp($tipoUser, "Administrador") == 0 || strcmp($tipoUser, "Reportero") == 0) { ?>
								<li><a href="panelNoticia.php">Subir noticia</a></li>
								<li><a href="listadoNoticias.php?id=<?php echo $idUser;?>&tipo=<?php echo $tipoUser;?>">Noticias sin publicar</a></li>
								<?php }
							} ?>
						</ul>
						<div id="divCuadroPerfil">
							<span id="txtCuadroPerfil">
								<?php
								if (isset($_SESSION["nombreULog"])) {
									$nomUser = $_SESSION['nombreULog']; ?>
									<a id="txtCuadroPerfil" href="perfil.php?id=<?php echo $idUser;?>">Hola <?php echo "$nomUser"; ?><a/>
										<?php if (isset($_SESSION['imgAvatarULog'])) { 
											$imgAvatarLog = $_SESSION['imgAvatarULog']; ?>
											<img id="imgCuadroPerfil" src="<?php echo 'images/profile/'.$imgAvatarLog; ?>" style="width: 50px; height: 50px;" >
											<?php } else { ?>
											<img id="imgCuadroPerfil" src="images/avatar.jpg" style="width: 50px; height: 50px;" >
											<?php } ?>
											<a id="txtDeslog" href="" onclick="">Cerrar sesión<a/>
										<?php } else {
											print_r('<a href="registro-login.php">Inicia sesión aquí<a/>');
										} ?>
									</span>
								</div>
							</div>
							<!--/.header-->
						</div>
					</nav>
				</div>
				<script>
				function clickDeslog() {
					<?php					
					?>
				}
				</script>
			</div>
		</body>
		</html>