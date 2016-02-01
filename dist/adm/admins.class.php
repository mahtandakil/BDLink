<?php

//BDLinker - PHP PDO class creator 0.9.4
//admins class file

class admins{
	var $BDLink;
	var $BDRes;
	var $BDRegistry;
	var $BDCount;
	var $BDQuery;
	var $BDFilter;
	var $id;
	var $name;
	var $pass;
	var $fecha;
	var $token;

	function __construct(){
		$BDDataConfig = new BDLConfig();
		$BDDataHost = $BDDataConfig->BDDataHost;
		$BDDataName = $BDDataConfig->BDDataName;
		$BDDataUser = $BDDataConfig->BDDataUser;
		$BDDataPass = $BDDataConfig->BDDataPass;
		$this->BDLink = new PDO("mysql:host=$BDDataHost;dbname=$BDDataName", "$BDDataUser", "$BDDataPass");
	}

	function __destruct(){
		unset($this->BDLink);
	}

	function lanzarConsulta($consulta){
		$this->BDQuery = $consulta;
		$this->BDRes = $this->BDLink->prepare($consulta);
		$this->BDRes->execute();
		return $this->BDRes;
	}

	function siguiente(){
		$this->BDRegistry = $this->BDRes->fetch();
		$this->id = $this->BDRegistry['id'];
		$this->name = $this->BDRegistry['name'];
		$this->pass = $this->BDRegistry['pass'];
		$this->fecha = $this->BDRegistry['fecha'];
		$this->token = $this->BDRegistry['token'];
		if($this->id == null){
			return false;
		}else{
			return true;
		}
	}

	function insertar($id, $name, $pass, $fecha, $token){
		$this->BDQuery = "INSERT INTO admins VALUES ('$id', '$name', '$pass', '$fecha', '$token');";
		$this->lanzarConsulta($this->BDQuery);
		$this->id = $id;
		$this->name = $name;
		$this->pass = $pass;
		$this->fecha = $fecha;
		$this->token = $token;
	}

	function insertar_(){
		$this->BDQuery = "INSERT INTO admins VALUES (" . $this->id . ", " . $this->name . ", " . $this->pass . ", " . $this->fecha . ", " . $this->token . ");";
		$this->lanzarConsulta($this->BDQuery);
	}

	function modificar($id, $name, $pass, $fecha, $token, $Claveid){
		$this->BDQuery = "UPDATE admins SET id = '$id', name = '$name', pass = '$pass', fecha = '$fecha', token = '$token' WHERE id = '$Claveid' LIMIT 1;";
		$this->lanzarConsulta($this->BDQuery);
		$this->id = $id;
		$this->name = $name;
		$this->pass = $pass;
		$this->fecha = $fecha;
		$this->token = $token;
	}

	function modificarId($id, $Claveid){
		$this->BDQuery = "UPDATE admins SET id = '$id' WHERE id = '$Claveid';";
		$this->lanzarConsulta($this->BDQuery);
		$this->id = $id;
	}

	function modificarName($name, $Claveid){
		$this->BDQuery = "UPDATE admins SET name = '$name' WHERE id = '$Claveid';";
		$this->lanzarConsulta($this->BDQuery);
		$this->name = $name;
	}

	function modificarPass($pass, $Claveid){
		$this->BDQuery = "UPDATE admins SET pass = '$pass' WHERE id = '$Claveid';";
		$this->lanzarConsulta($this->BDQuery);
		$this->pass = $pass;
	}

	function modificarFecha($fecha, $Claveid){
		$this->BDQuery = "UPDATE admins SET fecha = '$fecha' WHERE id = '$Claveid';";
		$this->lanzarConsulta($this->BDQuery);
		$this->fecha = $fecha;
	}

	function modificarToken($token, $Claveid){
		$this->BDQuery = "UPDATE admins SET token = '$token' WHERE id = '$Claveid';";
		$this->lanzarConsulta($this->BDQuery);
		$this->token = $token;
	}

	function modificar_(){
		$this->BDQuery = "UPDATE admins SET id = '" . $this->id . "', name = '" . $this->name . "', pass = '" . $this->pass . "', fecha = '" . $this->fecha . "', token = '" . $this->token . "' WHERE id = " . $this->id . " LIMIT 1;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function borrar($Claveid){
		$this->BDQuery = "DELETE FROM admins WHERE id = '$Claveid' LIMIT 1;";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$this->id = null;
		$this->name = null;
		$this->pass = null;
		$this->fecha = null;
		$this->token = null;
	}

	function borrarPorId($id){
		$this->BDQuery = "DELETE FROM admins WHERE id = '$id';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$id = null;
		$name = null;
		$pass = null;
		$fecha = null;
		$token = null;
	}

	function borrarPorName($name){
		$this->BDQuery = "DELETE FROM admins WHERE name = '$name';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$id = null;
		$name = null;
		$pass = null;
		$fecha = null;
		$token = null;
	}

	function borrarPorPass($pass){
		$this->BDQuery = "DELETE FROM admins WHERE pass = '$pass';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$id = null;
		$name = null;
		$pass = null;
		$fecha = null;
		$token = null;
	}

	function borrarPorFecha($fecha){
		$this->BDQuery = "DELETE FROM admins WHERE fecha = '$fecha';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$id = null;
		$name = null;
		$pass = null;
		$fecha = null;
		$token = null;
	}

	function borrarPorToken($token){
		$this->BDQuery = "DELETE FROM admins WHERE token = '$token';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$id = null;
		$name = null;
		$pass = null;
		$fecha = null;
		$token = null;
	}

	function borrar_(){
		$this->BDQuery = "DELETE FROM admins WHERE id = " . $this->id . " LIMIT 1;";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDRegistry = null;
		$this->id = null;
		$this->name = null;
		$this->pass = null;
		$this->fecha = null;
		$this->token = null;
	}

	function buscarPorId($id){
		$this->BDQuery = "SELECT * FROM admins WHERE id = '$id';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorName($name){
		$this->BDQuery = "SELECT * FROM admins WHERE name = '$name';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorPass($pass){
		$this->BDQuery = "SELECT * FROM admins WHERE pass = '$pass';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorFecha($fecha){
		$this->BDQuery = "SELECT * FROM admins WHERE fecha = '$fecha';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorToken($token){
		$this->BDQuery = "SELECT * FROM admins WHERE token = '$token';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorId_(){
		$this->BDQuery = "SELECT * FROM admins WHERE id = '" . $this->id . "';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorName_(){
		$this->BDQuery = "SELECT * FROM admins WHERE name = '" . $this->name . "';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorPass_(){
		$this->BDQuery = "SELECT * FROM admins WHERE pass = '" . $this->pass . "';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorFecha_(){
		$this->BDQuery = "SELECT * FROM admins WHERE fecha = '" . $this->fecha . "';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function buscarPorToken_(){
		$this->BDQuery = "SELECT * FROM admins WHERE token = '" . $this->token . "';";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listar(){
		$this->BDQuery = "SELECT * FROM admins;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarCrecientePorId(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY id ASC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarDecrecientePorId(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY id DESC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarCrecientePorName(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY name ASC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarDecrecientePorName(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY name DESC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarCrecientePorPass(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY pass ASC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarDecrecientePorPass(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY pass DESC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarCrecientePorFecha(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY fecha ASC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarDecrecientePorFecha(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY fecha DESC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarCrecientePorToken(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY token ASC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function listarDecrecientePorToken(){
		$this->BDQuery = "SELECT * FROM admins ORDER BY token DESC;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function contar(){
		$this->BDQuery = "SELECT count(*) FROM admins;";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiId($id){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE id = '$id';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiName($name){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE name = '$name';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiPass($pass){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE pass = '$pass';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiFecha($fecha){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE fecha = '$fecha';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiToken($token){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE token = '$token';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiId_($id){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE id = '" . $this->id . "';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiName_($name){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE name = '" . $this->name . "';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiPass_($pass){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE pass = '" . $this->pass . "';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiFecha_($fecha){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE fecha = '" . $this->fecha . "';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function contarSiToken_($token){
		$this->BDQuery = "SELECT count(*) FROM admins WHERE token = '" . $this->token . "';";
		$this->lanzarConsulta($this->BDQuery);
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function vaciar(){
		$this->BDQuery = "TRUNCATE TABLE admins;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function optimizar(){
		$this->BDQuery = "OPTIMIZE TABLE admins;";
		$this->lanzarConsulta($this->BDQuery);
	}

	function lanzarFiltro(){
		$this->crearConsultaFiltro(0);
		$this->lanzarConsulta($this->BDQuery);
	}

	function contarFiltro(){
		$this->crearConsultaFiltro(1);
		$this->lanzarConsulta($this->BDQuery);
		$this->lanzarConsulta("SELECT FOUND_ROWS();");
		$this->BDCount = $this->BDRes->fetchColumn();
	}

	function filtroBinario(){
		$this->BDFilter["binario"] = " COLLATE utf8_bin";
	}

	function crearConsultaFiltro($variacion){
		if($variacion == 0){
			$this->BDQuery = "SELECT * FROM admins";
		}else if($variacion == 1){
			$this->BDQuery = "SELECT SQL_CALC_FOUND_ROWS * FROM admins";
		}
		$conta = 0;
		foreach($this->BDFilter["seleccion"] as $registroFiltrado){
			$conta++;
			if($conta == 1){
				$this->BDQuery = "$this->BDQuery WHERE $registroFiltrado";
			}else{
				$this->BDQuery = "$this->BDQuery AND $registroFiltrado";
			}
		}
		if(! ($filtro == "")){
			$this->BDQuery = "$this->BDQuery $filtro";
		}
		if(! ($this->BDFilter["orden"] == null)){
			$filtro = $this->BDFilter["orden"];
			$this->BDQuery = "$this->BDQuery ORDER BY $filtro";
		}
		if(! ($this->BDFilter["registros"] == null)){
			if(! ($this->BDFilter["pagina"] == null)){
				$filtro = $this->BDFilter["pagina"] . ", " . $this->BDFilter["registros"];
			}else{
				$filtro = $this->BDFilter["registros"];
			}
			$this->BDQuery = "$this->BDQuery LIMIT $filtro";
		}
		$this->BDQuery = "$this->BDQuery" . $this->BDFilter["binario"] . ";";
	}

	function crearFiltro(){
		$this->BDFilter = array("orden" => null, "registros" => null, "binario" => "", "pagina" => null, "seleccion" => array());
	}

	function filtrarLimite($pagina, $registros){
		$this->BDFilter["pagina"] = $pagina;
		$this->BDFilter["registros"] = $registros;
	}

	function filtrarId($valorFiltro){
		$this->BDFilter["seleccion"][] = "id $valorFiltro";
	}

	function filtrarCrecientePorId(){
		$this->BDFilter["orden"] = "id ASC";
	}

	function filtrarDecrecientePorId(){
		$this->BDFilter["orden"] = "id DESC";
	}

	function filtrarName($valorFiltro){
		$this->BDFilter["seleccion"][] = "name $valorFiltro";
	}

	function filtrarCrecientePorName(){
		$this->BDFilter["orden"] = "name ASC";
	}

	function filtrarDecrecientePorName(){
		$this->BDFilter["orden"] = "name DESC";
	}

	function filtrarPass($valorFiltro){
		$this->BDFilter["seleccion"][] = "pass $valorFiltro";
	}

	function filtrarCrecientePorPass(){
		$this->BDFilter["orden"] = "pass ASC";
	}

	function filtrarDecrecientePorPass(){
		$this->BDFilter["orden"] = "pass DESC";
	}

	function filtrarFecha($valorFiltro){
		$this->BDFilter["seleccion"][] = "fecha $valorFiltro";
	}

	function filtrarCrecientePorFecha(){
		$this->BDFilter["orden"] = "fecha ASC";
	}

	function filtrarDecrecientePorFecha(){
		$this->BDFilter["orden"] = "fecha DESC";
	}

	function filtrarToken($valorFiltro){
		$this->BDFilter["seleccion"][] = "token $valorFiltro";
	}

	function filtrarCrecientePorToken(){
		$this->BDFilter["orden"] = "token ASC";
	}

	function filtrarDecrecientePorToken(){
		$this->BDFilter["orden"] = "token DESC";
	}



}

?>