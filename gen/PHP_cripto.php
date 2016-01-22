<?php

//--------------------------------------------------------------------------------------------

function encriptar($cadena, $clave){
	
	$cifrado = MCRYPT_RIJNDAEL_256;
	$modo = MCRYPT_MODE_ECB;
	
	$resultado = mcrypt_encrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));
	print $resultado . "<br>";
	print base64_encode($resultado) . "<br>";
	
}


//--------------------------------------------------------------------------------------------

function desencriptar($cadena, $clave){
	
	$cifrado = MCRYPT_RIJNDAEL_256;
	$modo = MCRYPT_MODE_ECB;
	
	$resultado = mcrypt_encrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));
	print $resultado . "<br>";
	print base64_encode($resultado) . "<br>";
	
}


//--------------------------------------------------------------------------------------------

?>
