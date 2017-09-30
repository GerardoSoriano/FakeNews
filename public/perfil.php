<?php
error_reporting(E_ALL);
$idUserLog = $_GET['id'];
include("conexionBD.php");
require_once "DVUsuario.php";
$connection = conectarBD();

$querySeccion = "CALL obtenerDatosUsuario($idUserLog)";
$resultQuery = mysqli_query($connection, $querySeccion) or die ("Hubo un error al consultar la base de datos");
mysqli_close($connection);

if ($resultQuery->num_rows) {
	$rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $row) {
		$usuarioComplete =  new DVUsuario(
			$row['idUsuario'],
			$row['nombre'],
			$row['apellidos'],
			$row['correo'],
			$row['contrasenia'],
			$row['telefono'],
			$row['fechaNacimiento'],
			$row['tipoUsuario'],
			$row['imgAvatar'],
			$row['imgPortada']);
	}
}
$diaNac = substr($usuarioComplete->fechaNacimiento, 0, 2);
$mesNac = substr($usuarioComplete->fechaNacimiento, 3, -5);
$anioNac = substr($usuarioComplete->fechaNacimiento, -4);
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
	12=> "12");
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
	20=> "1998",
	21=> "1997",
	22=> "1996",
	23=> "1995",
	24=> "1994",
	25=> "1993",
	26=> "1992",
	27=> "1991",
	28=>"1990",
	29=> "1989",
	30=> "1988",
	31=>"1987",
	32=> "1986",
	33=> "1985",
	34=> "1984",
	35=> "1983",
	36=> "1982",
	37=> "1981",
	38=> "1980",
	39=> "1979",
	40=>"1978",
	41=> "1977",
	42=> "1976",
	43=> "1975",
	44=> "1974",
	45=> "1973",
	46=> "1972",
	47=> "1971",
	48=> "1970",
	49=>"1969",
	50=> "1968",
	51=> "1967",
	52=> "1966",
	53=> "1965",
	54=> "1964",
	55=> "1963",
	56=> "1962",
	57=> "1960",
	58=>"1959",
	59=> "1958",
	60=> "1957",
	61=>"1956",
	62=> "1955",
	63=> "1954",
	64=> "1953",
	65=> "1952",
	66=> "1951",
	67=> "1950",
	68=> "1949",
	69=> "1948",
	70=>"1947",
	71=> "1946",
	72=> "1945",
	73=> "1944",
	74=> "1943",
	75=> "1942",
	76=> "1941",
	77=> "1940",
	78=> "1939",
	79=>"1938",
	80=> "1937",
	81=> "1936",
	82=> "1935",
	83=> "1934",
	84=> "1933",
	85=> "1932",
	86=> "1931",
	87=> "1930",
	88=>"1929",
	89=> "1928",
	90=> "1927",
	91=> "1926",
	92=> "1925",
	93=> "1924",
	94=> "1923",
	95=> "1922",
	96=>"1921",
	97=> "1920",
	98=> "1919",
	99=> "1918",
	100=> "1917");
	?>
	<!DOCTYPE HTML>
	<html>
	<head>
		<title>Perfil de <?php echo $usuarioComplete->nombre." ".$usuarioComplete->apellidos;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Noticias, Web Noticias, Telediario" />
	</head>
	<body>
		<?php
		include_once("header.php");
		if (isset($_SESSION["tipoULog"])) {
			$tipoUser = $_SESSION["tipoULog"];
		}
		?>
		<form enctype="multipart/form-data" action="usuario_update_success.php" method="POST">
			<div class="divPortadaPerfil">
				<img src="<?php echo 'images/profile/'.$usuarioComplete->imgPortada; ?>" class="imgPortada" id="imgOutputPortada">
				<input id="inpImgPortada" type="hidden" name="txtImgPortada" value="<?php echo $usuarioComplete->imgPortada; ?>">
				<input class="btnEditarPortada" type="file" accept="image/*" name="inpImgPortada" onchange="loadFilePort(event)" />
				<script>
				var loadFilePort = function (event) {
					var output = document.getElementById('imgOutputPortada');
					output.src = URL.createObjectURL(event.target.files[0]);
				};
				</script>
			</div>
			<div class="account">
				<div class="container">
					<div class="account-bottom">
						<div class="col-md-6 account-left">
							<?php
							if ($tipoUser != NULL && strcmp($tipoUser, "Administrador") == 1) { ?>
							<div class="divBtnEditar">
								<button id="inpEditar" class="btnEditar" type="button" onclick="functionIsDisabled('inpEditar');">Editar</button>
								<button id="inpEliminar" class="btnEditar" type="button" onclick="">Eliminar cuenta</button>
							</div>
							<?php } else { ?>
							<div class="divBtnEditar">
								<button id="inpEditar" class="btnEditar" type="button" onclick="functionIsDisabled('inpEditar');">Editar</button>
							</div>
							<?php } ?>
							<div class="address">
								<span>Tipo de cuenta</span>
								<?php
								if ($tipoUser != NULL && strcmp($tipoUser, "Administrador") == 0) { ?>
								<select id="inpTipo" name="txtTipoCuenta" placeholder="" disabled>
									<option value="<?php echo $usuarioComplete->tipoUsuario; ?>" selected><?php echo $usuarioComplete->tipoUsuario; ?></option>
									<option>Normal</option>
									<option>Reportero</option>
								</select>
								<?php } else if ($tipoUser != NULL && strcmp($tipoUser, "Reportero") == 0) {?>
								<select id="inpTipo" name="txtTipoCuenta" placeholder="" disabled>
									<option value="<?php echo $usuarioComplete->tipoUsuario; ?>" selected><?php echo $usuarioComplete->tipoUsuario; ?></option>
									<option>Normal</option>
								</select>
								<?php } else { ?>
								<select id="inpTipo" name="txtTipoCuenta" placeholder="" disabled>
									<option value="<?php echo $usuarioComplete->tipoUsuario; ?>" selected><?php echo $usuarioComplete->tipoUsuario; ?></option>
								</select>
								<?php }?>
							</div>
							<div class="address">
								<span>Nombre</span>
								<input id="inpIdUsuario" type="hidden" name="txtIdUsuario" value="<?php echo $usuarioComplete->idUsuario; ?>" disabled>
								<input id="inpNombre" type="text" name="txtNombre" value="<?php echo $usuarioComplete->nombre; ?>" disabled>
							</div>
							<div class="address">
								<span>Apellidos</span>
								<input id="inpApellidos" type="text" name="txtApellidos" value="<?php echo $usuarioComplete->apellidos; ?>" disabled>
							</div>
							<div class="address">
								<span>Correo electronico</span>
								<input id="inpEmail" type="text" name="txtEmail" value="<?php echo $usuarioComplete->correo; ?>" disabled>
							</div>
							<div class="address">
								<span>Contraseña</span>
								<input id="inpContrasenia" type="password" name="txtPassword" value="<?php echo $usuarioComplete->contrasenia; ?>" disabled>
							</div>
							<div class="address">
								<span>Fecha de nacimiento</span>
								<select id="inpNacDia" name="txtNacDia" placeholder="" disabled>
									<?php
									foreach($arrayDias as $key => $value) {
										if (strcmp($value, $diaNac) == 0) {
											echo "<option selected value=' $value '> $value </option>";	
										} else {
											echo "<option value=' $value '> $value </option>";
										}
									} ?>
								</select>
								<select id="inpNacMes" name="txtNacMes" placeholder="" disabled>
									<?php
									foreach($arrayMes as $key => $value) {
										if (strcmp($value, $mesNac) == 0) {
											echo "<option selected value=' $value '> $value </option>";	
										} else {
											echo "<option value=' $value '> $value </option>";
										}
									} ?>
								</select>
								<select id="inpNacAnio" name="txtNacAnio" placeholder="" disabled>
									<?php
									foreach($arrayAnio as $key => $value) {
										if (strcmp($value, $anioNac) == 0) {
											echo "<option selected value=' $value '> $value </option>";	
										} else {
											echo "<option value=' $value '> $value </option>";
										}
									} ?>
								</select>
							</div>
							<div class="address">
								<span>Telefono (opcional)</span>
								<input id="inpTelefono" type="text" name="txtTelefono" value="<?php echo $usuarioComplete->telefono; ?>" disabled>
							</div>
							<div class="address new">
								<input id="inpSubmit" name="inpSubmit" type="submit" value="Guardar" disabled>
							</div>
						</div>
					</div>
					<div class="divImgAvatar">
						<div class="divBtnEditar">
							<input id="inpImgAvatar" type="hidden" name="txtImgAvatar" value="<?php echo $usuarioComplete->imgAvatar; ?>">
							<input type="file" accept="image/*" name="inpImgPerfil" onchange="loadFile(event)" />
						</div>
						<img src="<?php echo 'images/profile/'.$usuarioComplete->imgAvatar; ?>" class="imgPerfil" id="imgOutput">
						<script>
						var loadFile = function (event) {
							var output = document.getElementById('imgOutput');
							output.src = URL.createObjectURL(event.target.files[0]);
						};
						</script>
					</div>
				</form>
			</div>
		</div>
		<!--//end-main-->

		<?php
		include_once("footer.php");
		?>

		<script type="text/javascript">
		function functionIsDisabled(param1) {
			document.getElementById("inpIdUsuario").disabled = false;
			document.getElementById("inpNombre").disabled = false;
			document.getElementById("inpApellidos").disabled = false;
			document.getElementById("inpEmail").disabled = false;
			document.getElementById("inpContrasenia").disabled = false;
			document.getElementById("inpTelefono").disabled = false;
			document.getElementById("inpNacDia").disabled = false;
			document.getElementById("inpNacMes").disabled = false;
			document.getElementById("inpNacAnio").disabled = false;
			document.getElementById("inpSubmit").disabled = false;
			document.getElementById("inpTipo").disabled = false;
			// document.getElementById("inpEditar").style.display = "none";
			return false;
		}
		</script>
	</body>
	</html>