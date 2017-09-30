<!DOCTYPE HTML>
<?php  error_reporting(E_ALL);
include("conexionBD.php");
require_once "DVNoticia.php";
$connection = conectarBD();
$keyword = $_GET['txtKeywords'];

error_reporting(E_ALL);
$querySelect = "CALL busquedaNoticias('$keyword')";
$resultQuery = mysqli_query($connection, $querySelect) or die (mysqli_error($connection));
mysqli_close($connection);

if ($resultQuery->num_rows) {
	$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
	$arrayNoticias = array();
	foreach ($rows as $row) {
		$arrayNoticias[count($arrayNoticias)] = new DVNoticia(
			$row['idNoticia'],
			$row['titulo'],
			'',
			$row['seccion'],
			$row['idSeccion'],
			$row['fecha'],
			'',
			$row['autor'],
			$row['idUsuario'],
			'',
			'',
			'');
	}
}
?>
<html>
<head>
	<title>Noticias sin publicar</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Noticias, Web Noticias, Telediario" />
</head>
<body>
	<?php
	include_once("header.php");
	?>
	
	<div class="panelEdicion">
		<div class="container">
			<div class="divColumn">
				<h3>Resultados de '<?php echo $keyword; ?>'</h3>
				<br>
				<div class="listaNoticias">
					<ul class="ulListaNoticias">
						<?php
						for ($i=0; $i < count($arrayNoticias); $i++) {
							$elemento = $arrayNoticias[$i]; ?>
							<li class="elementLista">
								<div class="divElementNoti">
									<a class="txtTituloNV"  href="noticiaDetalle.php?id=<?php echo $elemento->idNoticia; ?>"><?php echo $elemento->titulo; ?><a/>
										<br>
										<span>Reportero: </span>
										<a class="txtAutorNV" href="perfil.php?id=<?php echo $elemento->idUsuario; ?>"><?php echo $elemento->autor; ?></a>
										<span>Fecha de publicación: </span>
										<span class="txtFechaNV"><?php echo $elemento->fecha; ?></span>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<?php
			include_once("footer.php");
			?>		
		</body>
		</html>