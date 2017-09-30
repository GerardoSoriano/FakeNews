<!DOCTYPE HTML>
<?php
error_reporting(E_ALL);
include("conexionBD.php");
require_once "DVComentario.php";
require_once "DVNoticia.php";
require_once "DVMultimedia.php";
require_once "DVSeccion.php";
require_once "DVLike.php";
$idNoticia = $_GET['id'];
$connection = conectarBD();
$querySelect = "CALL obtenerNoticiaCompletaById('$idNoticia')";
$resultQuery = mysqli_query($connection, $querySelect) or die (mysqli_error($connection));
mysqli_next_result($connection);

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

$selectCommens = "CALL obtenerComentarios('$idNoticia')";
$QueryCommens = mysqli_query($connection, $selectCommens) or die (mysqli_error($connection));
mysqli_next_result($connection);

$arrayComentarios = array();
if ($QueryCommens->num_rows) {
	$rows = $QueryCommens->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$arrayComentarios[count($arrayComentarios)] = new DVComentario(
			$row['idComentario'],
			$row['autor'],
			$row['idUsuario'],
			$row['imgAvatar'],
			$row['texto'],
			$row['fecha']);
	}
}

$querySeccion = "SELECT idSeccion, nombreSeccion FROM allseccionesconnoticias;";
$result = mysqli_query($connection, $querySeccion) or die (mysqli_error($connection));
mysqli_more_results($connection);

$arraySecciones = array();
if ($result->num_rows) {
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$arraySecciones[count($arraySecciones)] = new DVSeccion(
			$row['idSeccion'],
			$row['nombreSeccion'],
			'');
	}
}

$queryLike = "CALL obtenerLikesByNoti('$idNoticia')";
$Queryke = mysqli_query($connection, $queryLike) or die (mysqli_error($connection)); 
mysqli_next_result($connection);
if ($Queryke->num_rows) {
	$arrayLikes = array();
	$rows = $Queryke->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$arrayLikes[count($arrayLikes)] = new DVLike(
			$row['idLike'], 
			$row['idNoticia'],
			$row['idUsuario']);
	}
} 

$idNoti = (int) $noticiaComplete->idNoticia;
$queryMultimedia = "CALL obtenerMultimediaById('$idNoti')";
$Query = mysqli_query($connection, $queryMultimedia) or die (mysqli_error($connection));
if ($Query->num_rows) {
	$arrayMediaImg = array();
	$rows = $Query->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		if ($row['urlMedia'] != NULL && $row['urlMedia'] != "") {
			$arrayMediaImg[count($arrayMediaImg)] = new DVMultimedia(
				$row['idMultimedia'], 
				$row['idNoticia'],
				$row['urlMedia'],
				$row['tipoMedia']);
		}
	}
}
mysqli_close($connection); 

$arrayDias = array(
	1=>"01",
	2=> "02",
	3=> "03",
	4=> "04",
	5=> "05",
	6=> "06",
	7=> "07",
	8=> "08",
	9=> "09",
	10=>"10",
	11=> "11",
	12=> "12",
	13=> "13",
	14=> "14",
	15=> "15",
	16=> "16",
	17=> "17",
	18=> "18",
	19=>"19",
	20=> "20",
	21=> "21",
	22=> "22",
	23=> "23",
	24=> "24",
	25=> "25",
	26=> "26",
	27=> "27",
	28=>"28",
	29=> "29",
	30=> "30",
	31=> "31");
$arrayMes = array(
	'enero'=>"01",
	'febrero'=> "02",
	'marzo'=> "03",
	'abril'=> "04",
	'mayo'=> "05",
	'junio'=> "06",
	'julio'=> "07",
	'agosto'=> "08",
	'septiembre'=> "09",
	'octubre'=>"10",
	'noviembre'=> "11",
	'diciembre'=> "12");
$arrayAnio = array(
	1=>"2017",
	2=> "2016",
	3=> "2015",
	4=> "2014",
	5=> "2013",
	6=> "2012",
	7=> "2011",
	8=> "2010",
	9=> "2009",
	10=>"2008",
	11=> "2007",
	12=> "2006",
	13=> "2005",
	14=> "2004",
	15=> "2003",
	16=> "2002",
	17=> "2001",
	18=> "2000",
	19=>"1999",
	20=> "1998");

	?>
	<html>
	<head>
		<title><?php echo $noticiaComplete->titulo;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Noticias, Web Noticias, Telediario" />
	</head>
	<body>
		<?php
		include_once("header.php");
		?>
		<div class="main-content">
			<div class="container">
				<div class="mag-inner">
					<div class="col-md-8 mag-innert-left">
						<div class="single-left-grid">
							<div class="slideshow-container">
								<?php
								for ($i=0; $i <count($arrayMediaImg); $i++) {
									$elementoMedia = $arrayMediaImg[$i];?>
									<div class="mySlides">
										<?php
										if ($elementoMedia->tipoMedia == 'IMG') { ?>
										<img src="<?php echo 'images/'.$elementoMedia->urlMedia; ?>" style="width:100%">
										<?php } elseif ($elementoMedia->tipoMedia == 'VID') { ?>
										<video width="100%" height="320" controls>
											<source src="<?php echo 'videos/'.$elementoMedia->urlMedia; ?>" type="video/mp4">
											</video>
											<?php } ?>
										</div>
										<?php } ?>
										<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
										<a class="next" onclick="plusSlides(1)">&#10095;</a>
									</div>
									<br>

									<div style="text-align:center">
										<?php
										for ($i=0; $i < count($arrayMediaImg); $i++) { ?>
										<span class="dot" onclick="currentSlide(<?php $i ?>)"></span>
										<?php } ?> 
									</div>
									<h2><?php echo $noticiaComplete->titulo; ?></h2>
									<h4><?php echo $noticiaComplete->descripcion; ?></h4>
									<p class="textcComplete"> <?php echo $noticiaComplete->textoCompleto; ?></p>
									<div class="single-bottom">
										<?php $datePubli = new DateTime($noticiaComplete->fecha); ?>
										     <?php
                                                    if (isset($_SESSION["idULog"])) {
                                                        $idULog = $_SESSION["idULog"]; ?>
                                                        <?php
                                                        $isLiked = false;
                                                        for ($n=0; $n < count($arrayLikes); $n++) {
                                                            $elemAux = $arrayLikes[$n];
                                                            if ($idULog == $elemAux->idUsuario && $noticiaComplete->idNoticia == $elemAux->idNoticia) {
                                                                $isLiked = true;
                                                            }
                                                        }
                                                        for ($x=0; $x < count($arrayLikes); $x++) {
                                                            $elementoLike = $arrayLikes[$x];
                                                            if ($idULog == $elementoLike->idUsuario && $noticiaComplete->idNoticia == $elementoLike->idNoticia) { ?>
                                                                <form action="like_delete_success.php" method="POST" >
                                                                <input type="hidden" name="inpIdNoticia" value="<?php echo $elemento->idNoticia; ?>"/>
                                                                <input type="hidden" name="inpIdUsuario" value="<?php echo $idULog; ?>"/>
                                                                <input type="submit" id="btnLiked" value="Te gusta"/>
                                                            </form>
                                                            <?php break; } else if ($idULog == $elementoLike->idUsuario && $noticiaComplete->idNoticia != $elementoLike->idNoticia) { ?>
                                                            <form action="like_insert_success.php" method="POST">
                                                                <input type="hidden" name="inpIdNoticia" value="<?php echo $elemento->idNoticia; ?>"/>
                                                                <input type="hidden" name="inpIdUsuario" value="<?php echo $idULog; ?>"/>
                                                                <input type="submit" id="btnLike" value="¡ME GUSTA!"/>
                                                            </form>
                                                            <?php } else if ($idULog != $elementoLike->idUsuario && $noticiaComplete->idNoticia == $elementoLike->idNoticia) {
                                                                if (!$isLiked) { ?>
                                                                <form action="like_insert_success.php" method="POST">
                                                                    <input type="hidden" name="inpIdNoticia" value="<?php echo $elemento->idNoticia; ?>"/>
                                                                    <input type="hidden" name="inpIdUsuario" value="<?php echo $idULog; ?>"/>
                                                                    <input type="submit" id="btnLike" value="¡ME GUSTA!"/>
                                                                </form>
                                                                <?php } else { ?>
                                                            <?php } } ?>
                                                            <?php }
                                                        } ?>
										<ul>
											<li><span>Reportero:</span> <a href="perfil.php?id=<?php echo $noticiaComplete->idUsuario; ?>"><?php echo $noticiaComplete->autor; ?></a></li>
											<li><span>Fecha de publicacion </span><?php echo $datePubli->format('H:i:s')." del día ".$datePubli->format('d-m-Y'); ?></li>
											<li><span><?php echo count($arrayComentarios)." comentario(s)"; ?></span></li>
										</ul>
									</div>
								</div>
								<br>
								<?php
								for ($i=0; $i < count($arrayComentarios); $i++) { 
									$elementoComen = $arrayComentarios[$i]; 
									$date = new DateTime($elementoComen->fecha); ?>
									<div class="divCajaComentario">
										<img class="imgComentario" src="<?php echo 'images/profile/'.$elementoComen->urlMediaAvatar; ?>" style="width: 60px; height: 60px; float: left;">
										<a href="perfil.php?id=<?php echo $elementoComen->idUsuario;?>"><?php echo $elementoComen->nombreUsuario; ?></a>
										<br>
										<p><?php echo $elementoComen->textoComentario; ?></p>
										<span>Publicado a las <?php echo $date->format('H:i:s')." del día ".$date->format('d-m-Y'); ?></span>
										<?php
										if (isset($_SESSION["tipoULog"])) { 
											$tipoUserLog = $_SESSION["tipoULog"];
											if ($tipoUserLog == 'Administrador') { ?>
											<a href="comentario_delete_success.php?idComen=<?php echo $elementoComen->idComentario;?>&idNoti=<?php echo $noticiaComplete->idNoticia; ?>" style="float: right; padding-right: 3px;">Eliminar</a>
											<?php } elseif ($tipoUserLog == 'Reportero') {
												$idUserLogFirst = $_SESSION["idULog"];
												if ($idUserLogFirst == $noticiaComplete->idUsuario) { ?>
												<a href="comentario_delete_success.php?idComen=<?php echo $elementoComen->idComentario;?>&idNoti=<?php echo $noticiaComplete->idNoticia; ?>" style="float: right; padding-right: 3px;">Eliminar</a>
												<?php }
											} ?>
											<?php } ?>
											<hr>
										</div>
										<hr>
										<?php } ?>
										<div class="leave">
											<h4>Deja un comentario</h4>
											<form id="commentform" method="POST" action="comentario_insert_success.php">
												<p class="comment-form-author-name"><label for="author">Nombre</label>
													<?php
													if (isset($_SESSION["nombreULog"])) {
														$nomUserLog = $_SESSION["nombreULog"]." ".$_SESSION['apellidosULog']; ?>
														<input name="txtNombreUser" type="text" size="30" required="" readOnly="" value="<?php echo $nomUserLog; ?>">
														<?php } else { ?>
														<input name="txtNombreUser" type="text" size="30" required="" placeholder="Ingresa un nombre para identificarte" value="">
														<?php } ?>
													</p>
													<p class="comment-form-email">
														<label class="email">Correo eléctronico</label>
														<?php
														if (isset($_SESSION["correoULog"])) {
															$emailUserLog = $_SESSION["correoULog"]; ?>
															<input name="txtEmailUser" type="text" required="" readOnly="" value="<?php echo $emailUserLog; ?>">
															<?php } else { ?>
															<input name="txtEmailUser" type="text" required="" placeholder="Ingresa un correo eléctronico válido" 
															value="" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
															<?php } ?>
														</p>
														<br>
														<p class="comment-form-comment">
															<textarea placeholder="Comenta lo que quieras!" name="txtTextoUser" requerid=""></textarea>
														</p>
														<div class="clearfix"></div>
														<?php
														if (isset($_SESSION["idULog"])) {
															$idUserLog = $_SESSION["idULog"]; ?>
															<input name="txtIdUser" type="hidden" required="" value="<?php echo $idUserLog;?>">
															<?php } else { ?>
															<input name="txtIdUser" type="hidden" required="" value="">
															<?php } ?>
															<input name="txtIdNoticia" type="hidden" value="<?php echo $noticiaComplete->idNoticia; ?>" required="">
															<input name="txtIdCommentPapa" type="hidden" value="0" required="">
															<p class="form-submit">
																<input type="submit" value="Enviar">
															</p>
															<div class="clearfix"></div>
														</form>
													</div>
												</div>

												<div class="col-md-4 mag-inner-right">
													<!--/start-sign-up-->
													<div class="sign_main" style="background-color: #f8f8f8;">
														<h4 class="side">Secciones</h4>
														<ul>
															<?php
															if (count($arraySecciones) > 0) {
																for ($i=0; $i < count($arraySecciones); $i++) { 
																	$elemento = $arraySecciones[$i]; ?>
																	<li><a href="index.php?idSec=<?php echo $elemento->idSeccion; ?>"><?php echo $elemento->nombreSeccion; ?></a></li>
																	<?php }
																} ?>
															</ul>
														</div>
														<!--//end-sign-up-->    
													</div>

													<div class="col-md-4 mag-inner-right">
														<!--/start-sign-up-->
														<div class="sign_main" style="background-color: #f8f8f8;">
															<h4 class="side">Búsqueda</h4>
															<div class="sign_up">
																<form method="GET" action="listadoBusqueda.php">
																	<input type="text" name="txtKeywords" class="txtBusqueda" placeholder="Ingrese palabras clave aquí">
																	<input type="submit" value="Buscar">
																</form>
															</div>
															<div class="sign_up">
																<span>Búsqueda por fecha</span>
																<form method="POST" action="listadoBusquedaFecha.php">
																	<div class="address">
																		<span>Del día</span>
																		<select class="selectFecha" id="inpNacDia" name="txtDiaFrom" placeholder="">
																			<?php
																			foreach($arrayDias as $key => $value) {
																				echo "<option value=' $value '> $value </option>";
																			} ?>
																		</select>
																		<select class="selectFecha" id="inpNacMes" name="txtMesFrom" placeholder="">
																			<?php
																			foreach($arrayMes as $key => $value) {
																				echo "<option value=' $value '> $key </option>";
																			} ?>
																		</select>
																		<select class="selectFecha" id="inpNacAnio" name="txtAnioFrom" placeholder="">
																			<?php
																			foreach($arrayAnio as $key => $value) {
																				echo "<option value=' $value '> $value </option>";
																			} ?>
																		</select>
																	</div>
																	<div class="address">
																		<span>Al día</span>
																		<select class="selectFecha" id="inpNacDia" name="txtDiaTo" placeholder="">
																			<?php
																			foreach($arrayDias as $key => $value) {
																				echo "<option value=' $value '> $value </option>";
																			} ?>
																		</select>
																		<select class="selectFecha" id="inpNacMes" name="txtMesTo" placeholder="">
																			<?php
																			foreach($arrayMes as $key => $value) {
																				echo "<option value=' $value '> $key </option>";
																			} ?>
																		</select>
																		<select class="selectFecha" id="inpNacAnio" name="txtAnioTo" placeholder="">
																			<?php
																			foreach($arrayAnio as $key => $value) {
																				echo "<option value=' $value '> $value </option>";
																			} ?>
																		</select>
																	</div>
																	<input type="submit" value="Buscar">
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
										include_once("footer.php");
										?>

										<script type="text/javascript">
										var slideIndex = 1;
										showSlides(slideIndex);

										function plusSlides(n) {
											showSlides(slideIndex += n);
										}

										function currentSlide(n) {
											showSlides(slideIndex = n);
										}

										function showSlides(n) {
											var i;
											var slides = document.getElementsByClassName("mySlides");
											var dots = document.getElementsByClassName("dot");
											if (n > slides.length) {slideIndex = 1} 
												if (n < 1) {slideIndex = slides.length}
													for (i = 0; i < slides.length; i++) {
														slides[i].style.display = "none"; 
													}
													for (i = 0; i < dots.length; i++) {
														dots[i].className = dots[i].className.replace(" active", "");
													}
													slides[slideIndex-1].style.display = "block"; 
													dots[slideIndex-1].className += " active";
												}
												</script>
											</body>
											</html>