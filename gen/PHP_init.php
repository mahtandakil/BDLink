<?php

$VERSION = "0.9.4";

require_once "./PHP_cripto.php";
require_once "./PHP_data_base.class.php";
require_once "./PHP_searcher.php";

$step = $_GET["step"];
$source = $_GET["source"];

if($step == "1"){

	$generador = new DataBase($VERSION, $source);
	$generador->cargarConfiguracion();
	$generador->encriptarConfiguracion();
	$generador->crearFicheroConfiguracion();

	$generador->procesarTablas();

	$generador->crearFicheroEnlace();

}else{

	elegirXML();
	
}

?>

<br>
<br>
<center>
	<a href="..">Volver</a>
</center>
