<?php



class Maker{
	var $f;
	var $bd;
	var $table;
	var $output;
	var $serieAll;
	var $serieArgs;
	var $serieKeys;
	var $serieWhere;
	var $serieWhere_;

//--------------------------------------------------------------------------------------------

	function __construct($bd, $table){
		
		$this->bd = $bd;
		$this->table = $table;
		$this->output = "";
		$this->serieAll = "";
		$this->serieArgs  ="";
		$this->serieKeys = "";
		$this->serieWhere = "";
		$this->serieWhere_ = "";
				
	}
	
//--------------------------------------------------------------------------------------------

	function generate(){
	
		$this->prepareData();
	
		$this->makeFile();
		$this->initialize();
		
		$this->insert();
		$this->insertExtendido();
		$this->update();
		$this->updateSimple();
		$this->updateExtended();
		$this->delete();
		$this->deleteSimple();
		$this->deleteExtended();
		$this->searchSimple();
		$this->searchExtended();
		$this->listar();
		$this->listarOrdenado();
		$this->contar();
		$this->contarCriterio();
		$this->contarCriterioExtendido();
		$this->vaciar();
		$this->optimizar();
		
		$this->filtrarBasico();
		$this->filtrarModificadores();
		
		$this->finalize();
		$this->closeFile();
		
	}

//--------------------------------------------------------------------------------------------

	function makeFile(){

			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Crear fichero: ";
	
			$path = "../dist/" . $this->table->name . ".class.php";
			$this->f = fopen($path, "w+");
			
	
	
			echo "'$path'<br>";
		
	}
	
	
//--------------------------------------------------------------------------------------------

	function closeFile(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Finalizado<br><br>";
		
		fclose($this->f);
		
	}


//--------------------------------------------------------------------------------------------

	function initialize(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Cabeceras<br>";
		
		$output = "";
		$output = $output . "<?php\n\n";
		$output = $output . "//BDLinker - PHP PDO class creator " . $this->bd->version . "\n";
		$output = $output . "//" . $this->table->name . " class file\n\n";
		$output = $output . "class " . $this->table->name . "{\n";
		
		$output = $output . "	var \$BDLink;\n";
		$output = $output . "	var \$BDRes;\n";
		$output = $output . "	var \$BDRegistry;\n";
		$output = $output . "	var \$BDCount;\n";
		$output = $output . "	var \$BDQuery;\n";
		$output = $output . "	var \$BDFilter;\n";
		
		foreach($this->table->fields as $field){
			$output = $output . "	var \$" . $field->name . ";\n";
		}
		
		$output = $output . "\n";

		$output = $output . "	function __construct(){\n";
		$output = $output . "		\$BDDataConfig = new BDLConfig();\n";
		$output = $output . "		\$BDDataHost = \$BDDataConfig->BDDataHost;\n";
		$output = $output . "		\$BDDataName = \$BDDataConfig->BDDataName;\n";
		$output = $output . "		\$BDDataUser = \$BDDataConfig->BDDataUser;\n";
		$output = $output . "		\$BDDataPass = \$BDDataConfig->BDDataPass;\n";
		$output = $output . "		\$this->BDLink = new PDO(\"mysql:host=\$BDDataHost;dbname=\$BDDataName\", \"\$BDDataUser\", \"\$BDDataPass\");\n";
		$output = $output . "	}\n\n";
		
		$output = $output . "	function __destruct(){\n";
		$output = $output . "		unset(\$this->BDLink);\n";
		$output = $output . "	}\n\n";
		
		$output = $output . "	function lanzarConsulta(\$consulta){\n";
		$output = $output . "		\$this->BDQuery = \$consulta;\n";
		$output = $output . "		\$this->BDRes = \$this->BDLink->prepare(\$consulta);\n";
		$output = $output . "		\$this->BDRes->execute();\n";
		$output = $output . "		return \$this->BDRes;\n";
		$output = $output . "	}\n\n";
		
		$output = $output . "	function siguiente(){\n";
		$output = $output . "		\$this->BDRegistry = \$this->BDRes->fetch();\n";
		
		foreach($this->table->fields as $field){
			$output = $output . "		\$this->" . $field->name . " = \$this->BDRegistry['" . $field->name . "'];\n";
		}
		
		$output = $output . "		if(\$this->" . $this->table->baseKey->name . " == null){\n";
		$output = $output . "			return false;\n";
		$output = $output . "		}else{\n";
		$output = $output . "			return true;\n";
		$output = $output . "		}\n";
		$output = $output . "	}\n\n";


		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function finalize(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Cierres<br>";
		
		$output = "";
		$output = $output . "\n\n}\n\n";
		$output = $output . "?>";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function save($data){
		
		fprintf($this->f, "%s", $data);

	}


//--------------------------------------------------------------------------------------------

	function insert(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Insert<br>";
		
		$output = "";
		$output = $output . "	function insertar(" . $this->serieAll . "){\n";
		$output = $output . "		\$this->BDQuery = \"INSERT INTO " . $this->table->name . " VALUES (" . $this->serieArgs . ");\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		
		foreach($this->table->fields as $field){
			$output = $output . "		\$this->" . $field->name . " = \$" . $field->name . ";\n";
		}
		
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function insertExtendido(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Insert extendido<br>";
		
		$output = "";
		$output2 = "";
		$output = $output . "	function insertar_(){\n";
		$output = $output . "		\$this->BDQuery = \"INSERT INTO " . $this->table->name . " VALUES (";
		
		foreach($this->table->fields as $field){
			$output2 = $output2 . "\" . \$this->" . $field->name . " . \", ";
		}
		$output2 = substr ($output2, 0, strlen($output2) - 2);
		$output = $output . $output2;
		
		$output = $output . ");\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "	}\n\n";

		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function prepareData(){
		
		$counter = 0;
		
		foreach($this->table->fields as $field){
			
			$this->serieAll = $this->serieAll . "\$" . $field->name . ", ";
			$this->serieArgs = $this->serieArgs . "'\$" . $field->name . "', ";
			
			if(! ($field->key == "")){
				$this->serieKeys = $this->serieKeys . "\$Clave" . $field->name . ", ";
			
				if($counter == 0){
					$this->serieWhere = $this->serieWhere . $field->name . " = '\$Clave" . $field->name . "'";
					$this->serieWhere_ = $this->serieWhere_ . $field->name . " = \" . \$this->" . $field->name . " . \"";
				
				}else{
					$this->serieWhere = $this->serieWhere . " AND \$" . $field->name . " = '\$Clave" . $field->name . "'";			
					$this->serieWhere_ = $this->serieWhere_ . " AND " . $field->name . " = \" . \$this->" . $field->name . " . \"";
				
				}
				
			}
			
			$counter++;
			
		}
		
		$this->serieAll = substr ($this->serieAll, 0, strlen($this->serieAll) - 2);
		$this->serieArgs = substr ($this->serieArgs, 0, strlen($this->serieArgs) - 2);
		$this->serieKeys = substr ($this->serieKeys, 0, strlen($this->serieKeys) - 2);
		
	}


//--------------------------------------------------------------------------------------------

	function update(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Update<br>";
		
		$output = "";
		$output = $output . "	function modificar(" . $this->serieAll . ", " . $this->serieKeys . "){\n";
		$output = $output . "		\$this->BDQuery = \"UPDATE " . $this->table->name . " SET ";
		
		foreach($this->table->fields as $field){
			$output = $output . $field->name . " = '\$" . $field->name . "', ";
		}
		$output = substr ($output, 0, strlen($output) - 2);
		
		$output = $output . " WHERE " . $this->serieWhere . " LIMIT 1;\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		
		foreach($this->table->fields as $field){
			$output = $output . "		\$this->" . $field->name . " = \$" . $field->name . ";\n";
		}
		
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function updateSimple(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Update individual<br>";

		$output = "";
		foreach($this->table->fields as $field){
			
			$output = $output . "	function modificar" . ucfirst($field->name) . "(\$" . $field->name . ", " . $this->serieKeys . "){\n";
			$output = $output . "		\$this->BDQuery = \"UPDATE " . $this->table->name . " SET " . $field->name . " = '\$" . $field->name . "' WHERE " . $this->serieWhere . ";\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "		\$this->" . $field->name . " = \$" . $field->name . ";\n";
			$output = $output . "	}\n\n";
			
		}	
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function updateExtended(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Update extendido<br>";
		
		$output = "";
		$output = $output . "	function modificar_(){\n";
		$output = $output . "		\$this->BDQuery = \"UPDATE " . $this->table->name . " SET ";
		
		foreach($this->table->fields as $field){
			$output = $output . $field->name . " = '\" . \$this->" . $field->name . " . \"', ";
		}
		$output = substr ($output, 0, strlen($output) - 2);
		
		$output = $output . " WHERE " . $this->serieWhere_ . " LIMIT 1;\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
				
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}
	
	
//--------------------------------------------------------------------------------------------

	function delete(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Delete<br>";
		
		$output = "";
		$output = $output . "	function borrar(" . $this->serieKeys . "){\n";
		$output = $output . "		\$this->BDQuery = \"DELETE FROM " . $this->table->name . " WHERE " . $this->serieWhere . " LIMIT 1;\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "		\$this->BDRegistry = null;\n";
		
		foreach($this->table->fields as $field){
			$output = $output . "		\$this->" . $field->name . " = null;\n";
		}
		
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function deleteSimple(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Delete individual<br>";

		$output = "";
		foreach($this->table->fields as $field){
			
			$output = $output . "	function borrarPor" . ucfirst($field->name) . "(\$" . $field->name . "){\n";
			$output = $output . "		\$this->BDQuery = \"DELETE FROM " . $this->table->name . " WHERE " . $field->name . " = '\$" . $field->name . "';\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "		\$this->BDRegistry = null;\n";
			
			foreach($this->table->fields as $field2){
				$output = $output . "		\$" . $field2->name . " = null;\n";
			}
			
			$output = $output . "	}\n\n";
			
		}	
		
		$this->save($output);

	}


//--------------------------------------------------------------------------------------------

	function deleteExtended(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Delete extendido<br>";
		
		$output = "";
		$output = $output . "	function borrar_(){\n";
		$output = $output . "		\$this->BDQuery = \"DELETE FROM " . $this->table->name . " WHERE " . $this->serieWhere_ . " LIMIT 1;\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "		\$this->BDRegistry = null;\n";
		
		foreach($this->table->fields as $field){
			$output = $output . "		\$this->" . $field->name . " = null;\n";
		}
		
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}
	
	
//--------------------------------------------------------------------------------------------

	function searchSimple(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Busqueda simple<br>";
		
		$output = "";
		foreach($this->table->fields as $field){
			
			$output = $output . "	function buscarPor" . ucfirst($field->name) . "(\$" . $field->name . "){\n";
			$output = $output . "		\$this->BDQuery = \"SELECT * FROM " . $this->table->name . " WHERE " . $field->name . " = '\$" . $field->name . "';\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "	}\n\n";
		
		}
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function searchExtended(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Busqueda extendido<br>";
		
		$output = "";
		foreach($this->table->fields as $field){
			
			$output = $output . "	function buscarPor" . ucfirst($field->name) . "_(){\n";
			$output = $output . "		\$this->BDQuery = \"SELECT * FROM " . $this->table->name . " WHERE " . $field->name . " = '\" . \$this->" . $field->name . " . \"';\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "	}\n\n";
		
		}
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function listar(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Listar<br>";
		
		$output = "";
		$output = $output . "	function listar(){\n";
		$output = $output . "		\$this->BDQuery = \"SELECT * FROM " . $this->table->name . ";\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function listarOrdenado(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Listar ordenado<br>";
		
		$output = "";
		foreach($this->table->fields as $field){
			
			$output = $output . "	function listarCrecientePor" . ucfirst($field->name) . "(){\n";
			$output = $output . "		\$this->BDQuery = \"SELECT * FROM " . $this->table->name . " ORDER BY " . $field->name . " ASC;\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "	}\n\n";
			
			$output = $output . "	function listarDecrecientePor" . ucfirst($field->name) . "(){\n";
			$output = $output . "		\$this->BDQuery = \"SELECT * FROM " . $this->table->name . " ORDER BY " . $field->name . " DESC;\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "	}\n\n";
			
		}
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function a(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* DEV: Desarrollando<br>";
		
		$output = "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		$output = $output . "";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function contar(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Contar<br>";
		
		$output = "";
		$output = $output . "	function contar(){\n";
		$output = $output . "		\$this->BDQuery = \"SELECT count(*) FROM " . $this->table->name . ";\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "		\$this->BDCount = \$this->BDRes->fetchColumn();\n";
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function contarCriterio(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Contar con criterio<br>";
		
		$output = "";
		foreach($this->table->fields as $field){
			$output = $output . "	function contarSi" . ucfirst($field->name) . "(\$" . $field->name . "){\n";
			$output = $output . "		\$this->BDQuery = \"SELECT count(*) FROM " . $this->table->name . " WHERE " . $field->name . " = '\$" . $field->name . "';\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "		\$this->BDCount = \$this->BDRes->fetchColumn();\n";
			$output = $output . "	}\n\n";
		}
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function contarCriterioExtendido(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Contar con criterio extendido<br>";
		
		$output = "";
		foreach($this->table->fields as $field){
			$output = $output . "	function contarSi" . ucfirst($field->name) . "_(\$" . $field->name . "){\n";
			$output = $output . "		\$this->BDQuery = \"SELECT count(*) FROM " . $this->table->name . " WHERE " . $field->name . " = '\" . \$this->" . $field->name . " . \"';\";\n";
			$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
			$output = $output . "		\$this->BDCount = \$this->BDRes->fetchColumn();\n";
			$output = $output . "	}\n\n";
		}
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function vaciar(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Vaciar<br>";
		
		$output = "";
		$output = $output . "	function vaciar(){\n";
		$output = $output . "		\$this->BDQuery = \"TRUNCATE TABLE " . $this->table->name . ";\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function optimizar(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Optimizar<br>";
		
		$output = "";
		$output = $output . "	function optimizar(){\n";
		$output = $output . "		\$this->BDQuery = \"OPTIMIZE TABLE " . $this->table->name . ";\";\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "	}\n\n";
		
		$this->save($output);
		
	}


//--------------------------------------------------------------------------------------------

	function filtrarBasico(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Filtrado<br>";
		
		$output = "";
		$output = $output . "	function lanzarFiltro(){\n";
		$output = $output . "		\$this->crearConsultaFiltro(0);\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "	}\n\n";

		$output = $output . "	function contarFiltro(){\n";
		$output = $output . "		\$this->crearConsultaFiltro(1);\n";
		$output = $output . "		\$this->lanzarConsulta(\$this->BDQuery);\n";
		$output = $output . "		\$this->lanzarConsulta(\"SELECT FOUND_ROWS();\");\n";
		$output = $output . "		\$this->BDCount = \$this->BDRes->fetchColumn();\n";
		$output = $output . "	}\n\n";
		
		$output = $output . "	function filtroBinario(){\n";
		$output = $output . "		\$this->BDFilter[\"binario\"] = \" COLLATE utf8_bin\";\n";
		$output = $output . "	}\n\n";

		$output = $output . "	function crearConsultaFiltro(\$variacion){\n";
		$output = $output . "		if(\$variacion == 0){\n";
		$output = $output . "			\$this->BDQuery = \"SELECT * FROM " . $this->table->name . "\";\n";
		$output = $output . "		}else if(\$variacion == 1){\n";
		$output = $output . "			\$this->BDQuery = \"SELECT SQL_CALC_FOUND_ROWS * FROM " . $this->table->name . "\";\n";
		$output = $output . "		}\n";
		$output = $output . "		\$conta = 0;\n";
		$output = $output . "		foreach(\$this->BDFilter[\"seleccion\"] as \$registroFiltrado){\n";
		$output = $output . "			\$conta++;\n";
		$output = $output . "			if(\$conta == 1){\n";
		$output = $output . "				\$this->BDQuery = \"\$this->BDQuery WHERE \$registroFiltrado\";\n";
		$output = $output . "			}else{\n";
		$output = $output . "				\$this->BDQuery = \"\$this->BDQuery AND \$registroFiltrado\";\n";
		$output = $output . "			}\n";
		$output = $output . "		}\n";
		$output = $output . "		if(! (\$filtro == \"\")){\n";
		$output = $output . "			\$this->BDQuery = \"\$this->BDQuery \$filtro\";\n";
		$output = $output . "		}\n";
		$output = $output . "		if(! (\$this->BDFilter[\"orden\"] == null)){\n";
		$output = $output . "			\$filtro = \$this->BDFilter[\"orden\"];\n";
		$output = $output . "			\$this->BDQuery = \"\$this->BDQuery ORDER BY \$filtro\";\n";
		$output = $output . "		}\n";
		$output = $output . "		if(! (\$this->BDFilter[\"registros\"] == null)){\n";
		$output = $output . "			if(! (\$this->BDFilter[\"pagina\"] == null)){\n";
		$output = $output . "				\$filtro = \$this->BDFilter[\"pagina\"] . \", \" . \$this->BDFilter[\"registros\"];\n";
		$output = $output . "			}else{\n";
		$output = $output . "				\$filtro = \$this->BDFilter[\"registros\"];\n";
		$output = $output . "			}\n";
		$output = $output . "			\$this->BDQuery = \"\$this->BDQuery LIMIT \$filtro\";\n";
		$output = $output . "		}\n";
		$output = $output . "		\$this->BDQuery = \"\$this->BDQuery\" . \$this->BDFilter[\"binario\"] . \";\";\n";
		$output = $output . "	}\n\n";
		
		$output = $output . "	function crearFiltro(){\n";
		$output = $output . "		\$this->BDFilter = array(\"orden\" => null, \"registros\" => null, \"binario\" => \"\", \"pagina\" => null, \"seleccion\" => array());\n";
		$output = $output . "	}\n\n";

		$output = $output . "	function filtrarLimite(\$pagina, \$registros){\n";
		$output = $output . "		\$this->BDFilter[\"pagina\"] = \$pagina;\n";
		$output = $output . "		\$this->BDFilter[\"registros\"] = \$registros;\n";
		$output = $output . "	}\n\n";

		$this->save($output);
		
	}
	
	
//--------------------------------------------------------------------------------------------

	function filtrarModificadores(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Filtrar - modificadores<br>";
		
		$output = "";
		foreach($this->table->fields as $field){
			
			$output = $output . "	function filtrar" . ucfirst($field->name) . "(\$valorFiltro){\n";
			$output = $output . "		\$this->BDFilter[\"seleccion\"][] = \"" . $field->name . " \$valorFiltro\";\n";
			$output = $output . "	}\n\n";

			$output = $output . "	function filtrarCrecientePor" . ucfirst($field->name) . "(){\n";
			$output = $output . "		\$this->BDFilter[\"orden\"] = \"" . $field->name . " ASC\";\n";
			$output = $output . "	}\n\n";
			
			$output = $output . "	function filtrarDecrecientePor" . ucfirst($field->name) . "(){\n";
			$output = $output . "		\$this->BDFilter[\"orden\"] = \"" . $field->name . " DESC\";\n";
			$output = $output . "	}\n\n";
		
		}
		
		$this->save($output);
		
	}
	

//--------------------------------------------------------------------------------------------

}

?>
