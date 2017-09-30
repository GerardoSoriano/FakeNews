<!DOCTYPE HTML>
<?php
include("conexionBD.php");
require_once "DVSeccion.php";
$connection = conectarBD();
error_reporting(E_ALL);
$querySelect = "SELECT idSeccion, nombreSeccion, idUsuario FROM allsecciones;";
$resultQuery = mysqli_query($connection, $querySelect) or die ("No se realizo el query");
mysqli_close($connection);

$arraySecciones = array();
if ($resultQuery->num_rows) {
	$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$arraySecciones[count($arraySecciones)] = new DVSeccion($row['idSeccion'], $row['nombreSeccion'], $row['idUsuario']);		
	}
}
?>
<html>
<head>
	<title>Subir contenido</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Noticias, Web Noticias, Telediario" />
</head>
<body onload="getSeccion()">
	<?php
	include_once("header.php");
	?>
	
	<div class="panel">
		<div class="container">
			<div class="divColumnLeft">
				<h3>Subir nueva noticia</h3>
				<form action="noticia_success_page.php" method="POST">
					<div class="address">
						<span>Título</span>
						<input class="inpTitulo" type="text" name="txtTitulo" autofocus="true" required="">
					</div>
					<div class="address">
						<span>Sección</span>
						<select class= "selectSeccion" name="txtSeccion" tabindex="1" required="">
							<?php
							$num = count($arraySecciones);
							for ($i=0; $i < $num; $i++) {
								$elemento = $arraySecciones[$i];
								echo "<option value=$elemento->idSeccion>$elemento->nombreSeccion</option>";
							}
							?>
						</select>
					</div>
					<div class="address">
						<span>Descripción breve</span>
						<textarea type="text" name="txtDescripcion" tabindex="2"></textarea>
					</div>
					<div class="address">
						<?php
						$nomUser = $_SESSION["nombreULog"];
						$apellidosUser = $_SESSION["apellidosULog"];
						?>
						<span>Autor</span>
						<input class="inpAutor" type="text" name="txtAutor" tabindex="6" required="" readOnly="" value="<?php echo "$nomUser"." "."$apellidosUser";?>">
					</div>
					<div class="address">
						<span>¿Noticia especial?</span>
						<select class= "selectFecha" name="txtIsEspecial" required="" tabindex="7">
							<option value="0">No</option>
							<option value="1">Si</option>
						</select>
					</div>
					<div class="address">
						<span>Cintillo</span>
						<select class= "selectFecha" name="txtCintillo" required="" tabindex="8">
							<option value="NONE">NONE</option>
							<option value="REPORTAJE ESPECIAL">REPORTAJE ESPECIAL</option>
							<option value="ÚLTIMA HORA">ÚLTIMA HORA</option>
						</select>
					</div>
					<div class="address">
						<span>Texto completo</span>
						<textarea class="textareaTexto" type="text" tabindex="9" name="txtTextoCompleto" rows="20" required=""></textarea>
					</div>
					<div class="address new">
						<input name="inpGuardarNoti" type="submit" value="Guardar" tabindex="10">
					</div>
				</form>
			</div>

			<?php
			if (isset($_SESSION["tipoULog"])) {
				$tipoUser = $_SESSION["tipoULog"];
				if (strcmp($tipoUser, "Administrador") == 0) { ?>
					<div class="divColumnRight">
				<h3>Subir nueva sección</h3>
				<form action="seccion_success_page.php" method="POST">
					<div class="address">
						<span>Título</span>
						<input class="inpTitulo" type="text" name="txtTituloSecc" tabindex="8" required="">
					</div>
					<div class="address new">
						<input name="inpGuardarSecc" type="submit" value="Guardar" tabindex="9">
					</div>
				</form>
			</div>
			<br>
			<div class="divColumnRight">
				<h3>Editar seccion</h3>
				<form method="POST" action="seccion_update_success.php">
					<div class="address">
						<select id="inputIdSeccion"class="selectSeccion" name="IdSeccionUpdate" required="" onchange="getSeccion()">
							<?php
							$num = count($arraySecciones);
							for ($i=0; $i < $num; $i++) {
								$elemento = $arraySecciones[$i];
								echo "<option value=$elemento->idSeccion>$elemento->nombreSeccion</option>";
							}
							?>
						</select>
						<div class="address">
						<input id="inputTextSeccion" class="inpTitulo" type="text" name="txtTitleSecUpdate" required="">
					</div>
						<div class="address new">
							<input id="idBtnSubmitEditar" name="inpEditarSecc" type="submit" value="Actualizar">
						</div>
					</div>
				</form>
			</div>
			<br>
			<div class="divColumnRight">
				<h3>Eliminar seccion</h3>
				<form method="POST" action="seccion_delete_success.php">
					<div class="address">
						<select class= "selectSeccion" name="txtSeccionEliminar" required="">
							<?php
							$num = count($arraySecciones);
							for ($i=0; $i < $num; $i++) {
								$elemento = $arraySecciones[$i];
								echo "<option value=$elemento->idSeccion>$elemento->nombreSeccion</option>";
							}
							?>
						</select>
						<div class="address new">
							<input id="idBtnSubmitEliminar" name="inpEliminarSecc" type="submit" value="Eliminar" onclick="clicked(event);">
						</div>
					</div>
				</form>
			</div>
				<?php }
			} ?>
			<div class="clearfix"></div>
		</div>
	</div>

	<?php
	include_once("footer.php");
	?>

	<script type="text/javascript">
	function clicked(e){
		if(!confirm('Se eliminarán todas las noticias no publicadas que contenga la sección. ¿Deseas continuar?'))e.preventDefault();
	}
	</script>

	<script>
		function getSeccion() {
			var x = document.getElementById("inputIdSeccion");
			x = x.options[x.selectedIndex].text;
			document.getElementById("inputTextSeccion").value = x;
		}
		</script>
</body>
</html>