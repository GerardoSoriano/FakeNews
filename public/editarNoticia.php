<?php
error_reporting(E_ALL); 
$idNoticia = $_GET['id'];
include("conexionBD.php");
require_once "DVNoticia.php";
require_once "DVSeccion.php";
require_once "DVMultimedia.php";
$connection = conectarBD();
$querySelect = "CALL obtenerNoticiaCompletaById('$idNoticia')";
$resultQuery = mysqli_query($connection, $querySelect) or die (mysqli_error($connection));

if ($resultQuery->num_rows) {
	$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$noticiaComplete = new DVNoticia(
			$row['idNoticia'],
			$row['titulo'],
			$row['descripcion'],
			$row['seccion'],
			$row['idSeccion'],
			$row['fecha'],
			$row['texto'],
			$row['autor'],
			$row['idUsuario'],
			$row['isPublica'],
			$row['isEspecial'],
			$row['cintillo']);
	}
}
mysqli_next_result($connection);

$querySeccion = "SELECT idSeccion, nombreSeccion, idUsuario FROM allsecciones;";
$resultQuery = mysqli_query($connection, $querySeccion) or die ("Hubo un error al consultar la base de datos");
mysqli_more_results($connection);

$arraySecciones = array();
if ($resultQuery->num_rows) {
	$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$arraySecciones[count($arraySecciones)] = new DVSeccion(
			$row['idSeccion'], 
			$row['nombreSeccion'],
			$row['idUsuario']);
	}
}

$idNoti = (int) $idNoticia;
$queryMultimedia = "CALL obtenerMultimediaById('$idNoti')";
$resultQuery = mysqli_query($connection, $queryMultimedia) or die ("Hubo un error al consultar la base de datos");

$arrayMediaImg = array();
if ($resultQuery->num_rows) {
	$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$arrayMediaImg[count($arrayMediaImg)] = new DVMultimedia(
			$row['idMultimedia'], 
			$row['idNoticia'],
			$row['urlMedia'],
			$row['tipoMedia']);
	}
}

mysqli_close($connection);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Editar noticia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Noticias, Web Noticias, Telediario" />
</head>
<body onload="getSeccion()">
	<?php
	include_once("header.php");
	?>
	<div class="panelEdicion">
		<div class="container">
			<div class="columnEdit">
				<h3>Editar noticia</h3>
				<div>
					<form method="POST" action="noticia_delete_success.php">
						<div class="address">
							<input class="inpTitulo" readOnly="" type="hidden" name="txtIdNoticiaDelete" required="" value="<?php echo $noticiaComplete->idNoticia; ?>">
						</div>
						<div class="address new">
							<input name="inpGuardarMedia" type="submit" value="Eliminar noticia">
						</div>
					</form>
				</div>
				<form action="noticia_update_success.php" method="POST">
					<div class="address">
						<span>Validar noticia</span>
						<input class="inpTitulo" type="hidden" name="txtIdNoticia" required="" value="<?php echo $noticiaComplete->idNoticia; ?>">
						<select class= "selectValidacion" name="txtValidacion" tabindex="9" required="">
							<?php
							if (isset($_SESSION["tipoULog"])) {
								$tipoUser = $_SESSION["tipoULog"];
								if (strcmp($tipoUser, "Administrador") == 0) { 
									if (strcmp($noticiaComplete->isPublica, "0") == 0) { ?>
									<option value="1">Si</option>
									<option value="0" selected>No</option>
									<?php } ?>
									<?php } else { ?>
									<option value="0">No</option>
									<?php }
								} ?>	
							</select>
						</div>
						<div class="address">
							<span>Título</span>
							<input class="inpTitulo" type="text" name="txtTitulo" autofocus="true" required="" value="<?php echo $noticiaComplete->titulo; ?>">
						</div>
						<div class="address">
							<span>Sección</span>
							<select id="campoIdSeccion" class= "selectSeccion" name="txtIdSeccion" tabindex="1" required="" onchange="getSeccion()">
								<?php
								for ($i=0; $i < count($arraySecciones); $i++) { 
									$elemento = $arraySecciones[$i];
									if (strcmp($noticiaComplete->idSeccion, $elemento->idSeccion) == 0) { ?>
									<option value="<?php echo $elemento->idSeccion; ?>" selected><?php echo $elemento->nombreSeccion; ?></option>
									<?php } else { ?>
									<option value="<?php echo $elemento->idSeccion; ?>"><?php echo $elemento->nombreSeccion; ?></option>
									<?php }
								} ?>
							</select>
							<input id="campoTextSeccion" class="inpAutor" type="hidden" name="txtSeccion" required="">
						</div>
						<div class="address">
							<span>Descripción breve</span>
							<textarea type="text" name="txtDescripcion" tabindex="2"><?php echo $noticiaComplete->descripcion; ?></textarea>
						</div>
						<div class="address">
							<span>Autor</span>
							<input class="inpAutor" type="text" name="txtAutor" tabindex="6" required="" readOnly="" value="<?php echo $noticiaComplete->autor; ?>">
							<input class="inpAutor" type="hidden" name="txtIdAutor" tabindex="7" required="" readOnly="" value="<?php echo $noticiaComplete->idUsuario; ?>">
						</div>
						<div class="address">
							<span>¿Noticia especial?</span>
							<select class= "selectFecha" name="txtIsEspecial" required="" tabindex="7">
								<?php
								if ($noticiaComplete->isEspecial == '0') { ?>
								<option value="0" selected>No</option>
								<option value="1">Si</option>
								<?php } else { ?>
								<option value="0">No</option>
								<option value="1" selected>Si</option>
								<?php } ?>
							</select>
						</div>
						<div class="address">
							<span>Cintillo</span>
							<select class= "selectFecha" name="txtCintillo" required="" tabindex="8">
								<?php
								if ($noticiaComplete->cintillo == 'REPORTAJE ESPECIAL') { ?>
								<option value="NONE">NONE</option>
								<option value="REPORTAJE ESPECIAL" selected>REPORTAJE ESPECIAL</option>
								<option value="ÚLTIMA HORA">ÚLTIMA HORA</option>
								<?php }
								elseif ($noticiaComplete->cintillo == 'ÚLTIMA HORA') { ?>
								<option value="NONE">NONE</option>
								<option value="REPORTAJE ESPECIAL">REPORTAJE ESPECIAL</option>
								<option value="ÚLTIMA HORA" selected>ÚLTIMA HORA</option>
								<?php } else { ?>
								<option value="NONE" selected>NONE</option>
								<option value="REPORTAJE ESPECIAL">REPORTAJE ESPECIAL</option>
								<option value="ÚLTIMA HORA">ÚLTIMA HORA</option>
								<?php } ?>
							</select>
						</div>		
						<div class="address">
							<span>Texto completo</span>
							<textarea class="textareaTexto" type="text" tabindex="8" name="txtTextoCompleto" rows="20" required=""><?php echo $noticiaComplete->textoCompleto; ?></textarea>
						</div>
						<div class="address new">
							<input name="inpGuardarNoti" type="submit" value="Actualizar" tabindex="9">
						</div>
					</form>
				</div>
				<hr>
				<div class="columnEdit">
					<form enctype="multipart/form-data" action="images_upload_success.php" method="POST">
						<div class="address">
							<span>Sube una o varias imágenes (max 3)</span>
							<div class="divMediasNoticia">
								<?php
								$indice = 1;
								for ($i=0; $i < count($arrayMediaImg); $i++) {
									$elementoMedia = $arrayMediaImg[$i];
									if ($elementoMedia->tipoMedia == 'IMG') { ?>
									<img class="imgMediasImg" id="<?php echo 'idMediaImg0'.$indice; ?>" onchange="loadFilePort(event)" src="<?php echo 'images/'.$elementoMedia->urlMedia; ?>">
									<input type="file" accept="image/*" name="<?php echo 'inpImgNoti0'.$indice; ?>" />
									<input type="hidden" name="<?php echo 'inpIdMedia0'.$indice; ?>" value="<?php echo $elementoMedia->idMultimedia; ?>" />
									<?php
									$indice++; }
								} ?>
							</div>
						</div>
						<div class="address new">
							<input name="inpGuardarMedia" type="submit" value="Actualizar" tabindex="9">
						</div>
						<input class="inpTitulo" type="hidden" name="txtIdNoticiaMedia" required="" value="<?php echo $noticiaComplete->idNoticia; ?>">
					</form>
					<hr>
					<form enctype="multipart/form-data" action="videos_upload_success.php" method="POST">
						<div class="address">
							<span>Sube un o varios videos (max 3)</span>
							<div class="divMediasNoticia">
								<?php
								$indix = 1;
								for ($i=0; $i < count($arrayMediaImg); $i++) {
									$elementoVid = $arrayMediaImg[$i];
									if ($elementoVid->tipoMedia == 'VID') { ?>
									<span>Video actual</span>
									<span><?php echo $elementoVid->urlMedia; ?></span>								
									<input type="file" accept="video/*" name="<?php echo 'inpVidNoti0'.$indix; ?>" />
									<input type="hidden" name="<?php echo 'inpIdMediaVid0'.$indix; ?>" value="<?php echo $elementoVid->idMultimedia; ?>" />
									<?php
									$indix++; }
								} ?>
							</div>
						</div>
						<input class="inpTitulo" type="hidden" name="txtIdNoticiaMedia" required="" value="<?php echo $noticiaComplete->idNoticia; ?>">
						<div class="address new">
							<input name="inpGuardarVideo" type="submit" value="Actualizar">
						</div>
					</form>
				</div>
				<hr>
			</div>
		</div>

		<?php
		include_once("footer.php");
		?>
		<script>
		var loadFilePort = function (event) {
			var output = document.getElementById('idMediaImg03');
			console.log(output);
			output.src = URL.createObjectURL(event.target.files[0]);
		};
		</script>
		<script>
		function getSeccion() {
			var x = document.getElementById("campoIdSeccion");
			x = x.options[x.selectedIndex].text;
			document.getElementById("campoTextSeccion").value = x;
		}
		</script>
	</body>
	</html>