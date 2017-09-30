<?php  
error_reporting(0);
include("conexionBD.php");
require_once "DVNoticia.php";
require_once "DVMultimedia.php";
require_once "DVSeccion.php";
require_once "DVLike.php";
$connection = conectarBD();
mysqli_more_results($connection);
if ($_GET['idSec'] != NULL) {
    $idSecccion = (int) $_GET['idSec'];
    $chainSecc = $_GET['idSec'];
    if ($chainSecc == 'notCom') {
        $querySelect = "CALL obtenerNoticiasConMasComens();";
    } else if ($chainSecc == 'notLik') {
        $querySelect = "CALL obtenerNoticiasConMasLikes()";
    } else {
        $querySelect = "CALL obtenerNoticiasBySeccion('$idSecccion')";
    }
    $resultQuery = mysqli_query($connection, $querySelect) or die (mysqli_error($connection));
    if ($resultQuery->num_rows) {
        $rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
        $arrayNoticias = array();
        foreach ($rows as $row) {
            $arrayNoticias[count($arrayNoticias)] = new DVNoticia(
                $row['idNoticia'],
                $row['titulo'],
                $row['descripcion'],
                $row['seccion'],
                $row['idSeccion'],
                $row['FechaReciente'],
                '',
                $row['autor'],
                '',
                '',
                $row['isEspecial'],
                $row['cintillo']);
        }
    }
    mysqli_next_result($connection);
} else {
    $querySelect = "SELECT idNoticia, titulo, descripcion, idSeccion, seccion, autor, FechaReciente, isEspecial, cintillo FROM ultimasnoticiasvalidadas;";
    $resultQuery = mysqli_query($connection, $querySelect) or die (mysqli_error($connection));
    if ($resultQuery->num_rows) {
        $rows = $resultQuery->fetch_all(MYSQLI_ASSOC);
        $arrayNoticias = array();
        foreach ($rows as $row) {
            $arrayNoticias[count($arrayNoticias)] = new DVNoticia(
                $row['idNoticia'],
                $row['titulo'],
                $row['descripcion'],
                $row['seccion'],
                $row['idSeccion'],
                $row['FechaReciente'],
                '',
                $row['autor'],
                '',
                '',
                $row['isEspecial'],
                $row['cintillo']);
        }
    }
}
mysqli_more_results($connection);

$querySeccion = "SELECT idSeccion, nombreSeccion FROM allseccionesconnoticias;";
$result = mysqli_query($connection, $querySeccion) or die (mysqli_error($connection));

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
    20=> "1998"); ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Inicio</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Noticias, Web Noticias, Telediario" />
    </head>
    <body>
        <?php include_once("header.php"); ?>
        <!--/start-main-->
        <div class="main-content">
            <div class="container">
                <div class="mag-inner">
                    <div class="divHeaderNews">
                        <ul class="listaNewsHorizontal">
                            <?php
                            for ($i=0; $i < count($arrayNoticias); $i++) {
                                $element = $arrayNoticias[$i];
                                if ($element->isEspecial == '1') { ?>
                                <li>
                                    <div class="divNotiHeader">
                                        <?php
                                        $idNot = (int) $element->idNoticia;
                                        $queryHeader = "CALL obtenerMultimediaById('$idNot')";
                                        $QueryAlt = mysqli_query($connection, $queryHeader) or die (mysqli_error($connection)); 
                                        mysqli_next_result($connection);
                                        if ($QueryAlt->num_rows) {
                                            $arrayImg = array();
                                            $rows = $QueryAlt->fetch_all(MYSQLI_ASSOC);
                                            foreach ($rows as $row) {
                                                if ($row['urlMedia'] != NULL && $row['urlMedia'] != "" && $row['tipoMedia'] == "IMG") {
                                                    $arrayImg[count($arrayImg)] = new DVMultimedia(
                                                        $row['idMultimedia'], 
                                                        $row['idNoticia'],
                                                        $row['urlMedia'],
                                                        $row['tipoMedia']); ?>
                                                    <?php }
                                                }
                                                if (count($arrayImg > 0)) { ?>
                                                <img  src="<?php echo 'images/'.$arrayImg[0]->urlMedia; ?>" />
                                                <?php }
                                            } ?>
                                            <a href="noticiaDetalle.php?id=<?php echo $element->idNoticia; ?>"><?php echo $element->titulo; ?></a>
                                            <br>
                                            <a href="noticiaDetalle.php?id=<?php echo $element->idNoticia; ?>" style="color: #fff; background-color: #ee5656; padding: 3px"><?php echo $element->cintillo; ?></a>
                                        </div>
                                    </li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>
                        <div class="col-md-8 mag-innert-left" style="background-color: #f8f8f8;">
                            <a class="linkOrderNews"><a href="index.php?idSec=notCom">Noticias con más comentarios</a>
                            <a class="linkOrderNews"><a href="index.php?idSec=notLik">Noticias con más likes</a>
                            <?php
                            for ($i=0; $i < count($arrayNoticias); $i++) {
                                $elemento = $arrayNoticias[$i];
                                if ($elemento->isEspecial != 1) { ?>
                                <div class="divSeccion">
                                    <h2 class="tituloSeccion"><?php echo $elemento->seccion; ?></h2>
                                </div>
                                <div class="divNoticia">
                                    <?php
                                    $idNoti = (int) $elemento->idNoticia;
                                    $queryMultimedia = "CALL obtenerMultimediaById('$idNoti')";
                                    $Query = mysqli_query($connection, $queryMultimedia) or die (mysqli_error($connection)); 
                                    mysqli_next_result($connection);
                                    if ($Query->num_rows) {
                                        $arrayMediaImg = array();
                                        $rows = $Query->fetch_all(MYSQLI_ASSOC);
                                        foreach ($rows as $row) {
                                            if ($row['urlMedia'] != NULL && $row['urlMedia'] != "" && $row['tipoMedia'] == "IMG") {
                                                $arrayMediaImg[count($arrayMediaImg)] = new DVMultimedia(
                                                    $row['idMultimedia'],
                                                    $row['idNoticia'],
                                                    $row['urlMedia'],
                                                    $row['tipoMedia']); ?>
                                                <?php }
                                            }
                                            if (count($arrayMediaImg > 0)) { ?>
                                            <img style="width: 400px; height: 380px" class="imgNoticia" src="<?php echo 'images/'.$arrayMediaImg[0]->urlMedia; ?>" />
                                            <?php }
                                        } else { ?>
                                        <img class="imgNoticia" src="images/placeholder.png" alt="" />
                                        <?php } ?>
                                        <?php
                                        $queryLike = "CALL obtenerLikesByNoti('$idNoti')";
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
                                                } ?>
                                                <span style="float: right; padding-left: 5px; color: #428bca;"><?php echo count($arrayLikes); ?> Likes</span>
                                                <?php } else { ?>
                                                <span style="float: right; padding-left: 5px; color: #428bca; position: relative;">0 Likes</span>
                                                <?php } ?>
                                                <?php
                                                if (isset($_SESSION["idULog"])) {
                                                    $idULog = $_SESSION["idULog"]; ?>
                                                    <?php
                                                    $isLiked = false;
                                                    for ($n=0; $n < count($arrayLikes); $n++) {
                                                        $elemAux = $arrayLikes[$n];
                                                        if ($idULog == $elemAux->idUsuario && $elemento->idNoticia == $elemAux->idNoticia) {
                                                            $isLiked = true;
                                                        }
                                                    }
                                                    for ($x=0; $x < count($arrayLikes); $x++) {
                                                        $elementoLike = $arrayLikes[$x];
                                                        if ($idULog == $elementoLike->idUsuario && $elemento->idNoticia == $elementoLike->idNoticia) { ?>
                                                        <form action="like_delete_success.php" method="POST" style="float: right;">
                                                            <input type="hidden" name="inpIdNoticia" value="<?php echo $elemento->idNoticia; ?>"/>
                                                            <input type="hidden" name="inpIdUsuario" value="<?php echo $idULog; ?>"/>
                                                            <input type="submit" id="btnLiked" value="Te gusta"/>
                                                        </form>
                                                        <?php break; } else if ($idULog == $elementoLike->idUsuario && $elemento->idNoticia != $elementoLike->idNoticia) { ?>
                                                        <form action="like_insert_success.php" method="POST" style="float: right">
                                                            <input type="hidden" name="inpIdNoticia" value="<?php echo $elemento->idNoticia; ?>"/>
                                                            <input type="hidden" name="inpIdUsuario" value="<?php echo $idULog; ?>"/>
                                                            <input type="submit" id="btnLike" value="¡ME GUSTA!"/>
                                                        </form>
                                                        <?php } else if ($idULog != $elementoLike->idUsuario && $elemento->idNoticia == $elementoLike->idNoticia) {
                                                            if (!$isLiked) { ?>
                                                            <form action="like_insert_success.php" method="POST" style="float: right">
                                                                <input type="hidden" name="inpIdNoticia" value="<?php echo $elemento->idNoticia; ?>"/>
                                                                <input type="hidden" name="inpIdUsuario" value="<?php echo $idULog; ?>"/>
                                                                <input type="submit" id="btnLike" value="¡ME GUSTA!"/>
                                                            </form>
                                                            <?php break; } else { ?>
                                                            <?php }
                                                        }
                                                    }
                                                } ?>
                                                <div class="datosNoticia">
                                                    <span class="txtTitulo"><?php echo $elemento->titulo; ?></span>
                                                    <p class="txtDescripcion"><?php echo $elemento->descripcion; ?></p>
                                                    <p class="txtCredito">Publicado por: <?php echo $elemento->autor; ?></p>
                                                    <span class="txtFecha">Fecha: <?php echo $elemento->fecha; ?></span>
                                                    <a class="leerMas" href="noticiaDetalle.php?id=<?php echo $elemento->idNoticia; ?>">LEER MÁS</a>
                                                </div>
                                            </div>
                                            <?php }
                                        }
                                        mysqli_close($connection); ?>
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
            <!--//end-main-->
            <?php include_once("footer.php"); ?>
        </body>
        </html>