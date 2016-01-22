<?php

require_once "./PHP_table.class.php";


class DataBase{
	var $version;
	var $host;
	var $name;
	var $user;
	var $pass;
	var $crypt1;
	var $crypt2;
	var $crypt3;
	var $xmlIndex;
	var $configFolder;
	var $classFolder;
	var $useCrypt;
	var $xml;
	var $permisos;


//--------------------------------------------------------------------------------------------

	function __construct($version, $source){
		
		$this->version = $version;
		$this->source = "../xml/$source";
		$this->host = "";
		$this->name = "";
		$this->user = "";
		$this->pass = "";
		$this->crypt1 = Null;
		$this->crypt2 = Null;
		$this->crypt3 = Null;
		$this->permisos = 0755;
		
		$this->xmlIndex = Null;
		$this->configFolder = "";
		$this->classFolder = "";
		$this->destinationFolder = "";
		$this->useCrypt = False;
		$this->xml;
		
	}


//--------------------------------------------------------------------------------------------

	function rrmdir($dir) { 
		if (is_dir($dir)) { 
			$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") { 
					if (is_dir($dir."/".$object))
						rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object); 
				} 
			}
			rmdir($dir); 
		} 
	}


//--------------------------------------------------------------------------------------------
	
	function cargarConfiguracion(){

		$this->xml = simplexml_load_file($this->source);
		
		$this->xmlIndex = $this->xml->definicion->database;
		$valores = $this->xmlIndex->attributes();
		$this->host = $valores["server"];
		$this->name = $valores["name"];
		$this->user = $valores["user"];
		$this->pass = $valores["password"];
		$this->crypt1 = $valores["crypt1"];
		$this->crypt2 = $valores["crypt2"];
		$this->crypt3 = $valores["crypt3"];
			
		$this->configFolder = $valores["configFolder"];
		$this->classFolder = $valores["classFolder"];
		$this->destinationFolder = "../dist/" . $valores['distMod'];
	
		echo "* Configuracion cargada<br>";

	}

	
//--------------------------------------------------------------------------------------------

	function crearFicheroEnlace(){
	
		$f = fopen( "../dist/BDLink.class.php", "w+" );
		
		$codigo = "";
		$codigo = $codigo . "<?php\n\n";
		$codigo = $codigo . "// BDLinker - PHP PDO class creator $this->version\n";
		$codigo = $codigo . "// Link file\n\n";
		
		$codigo = $codigo . "include_once \"" . $this->configFolder . "BDLConfig.class.php\";\n";
		
		foreach($this->xml->definicion->database->tabla as $table){
			
			$metaTable = new Table($table);
			$metaTable->loadTableAttributes();
			$codigo = $codigo . "include_once \"" . $this->classFolder . "" . $metaTable->name . ".class.php\";\n";
			
		}
		
		fprintf($f, "%s", "$codigo");	
		
		fclose($f);
		
		echo "* Fichero de enlace creado<br>";
		
	}
	
	
//--------------------------------------------------------------------------------------------
	
	function crearFicheroConfiguracion(){
		
		$dir = $this->destinationFolder;
		if (is_dir($dir)) {
			$this->rrmdir($dir);
		}
		mkdir($dir);
		chmod($dir, $this->permisos);

		$f = fopen( "$dir/BDLConfig.class.php", "w+" );
	
		$codigo = "";
		$codigo = $codigo . "<?php\n\n";
		$codigo = $codigo . "// BDLinker - PHP PDO class creator $this->version\n";
		$codigo = $codigo . "// Config file\n\n";
		$codigo = $codigo . "class BDLConfig{\n";
		$codigo = $codigo . "	var \$BDDataHost;\n";
		$codigo = $codigo . "	var \$BDDataName;\n";
		$codigo = $codigo . "	var \$BDDataUser;\n";
		$codigo = $codigo . "	var \$BDDataPass;\n\n";
		$codigo = $codigo . "	function __construct(){\n";
		$codigo = $codigo . "		\$this->BDDataHost = '$this->host';\n";
		$codigo = $codigo . "		\$this->BDDataName = '$this->name';\n";
		$codigo = $codigo . "		\$this->BDDataUser = '$this->user';\n";
		$codigo = $codigo . "		\$this->BDDataPass = '$this->pass';\n";
		$codigo = $codigo . "	}\n\n";
		$codigo = $codigo . "";
		$codigo = $codigo . "";
		
		
		$codigo = $codigo . "";
		$codigo = $codigo . "}\n\n";
		$codigo = $codigo . "?>";	
		
		fprintf($f, "%s", "$codigo");	
		
		fclose($f);
		
		echo "* Fichero de configuracion creado<br>";
		
	}	
	
	
//--------------------------------------------------------------------------------------------
	
	function encriptarConfiguracion(){
		
		if(! (($this->crypt1 == "") && ($this->crypt2 == "") && ($this->crypt3 == ""))){
			
			$this->useCrypt = True;
			
			srand (time());
			$this->host = encriptar($this->host, $this->crypt1) . rand(2000,8000);
			$this->name = encriptar($this->name, $this->crypt1) . rand(2000,8000);
			$this->user = encriptar($this->user, $this->crypt1) . rand(2000,8000);
			$this->pass = encriptar($this->pass, $this->crypt1) . rand(2000,8000);
			
		}else{
			$this->useCrypt = False;
		
		}
		
	
		echo "! DEV: ADVERTENCIA!!!!! los suspuestos para encriptacion no estan terminados (PHP_data_base.class -> encriptarConfiguracion())<br>";
		echo "* Encriptacion terminada<br>";
		
	}
	
	
//--------------------------------------------------------------------------------------------
	
	function procesarTablas(){
	
		echo "* Procesando tablas<br><br>";
	
		foreach($this->xml->definicion->database->tabla as $table){
	
			$metaTable = new Table($table);
			$metaTable->loadTableAttributes();
			$metaTable->loadFields();
			$metaTable->generate($this);
	
		}
		
	}
	
	
//--------------------------------------------------------------------------------------------


}

?>
