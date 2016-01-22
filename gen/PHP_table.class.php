<?php

require_once "./PHP_field.class.php";
require_once "./PHP_maker.class.php";


class Table{
	var $index;
	var $fields;
	var $keyFields;
	var $baseKey;
	var $name;
	var $total_fields;
	var $engine;

//--------------------------------------------------------------------------------------------

	function __construct($index){
		
		$this->index = $index;
		
	}


//--------------------------------------------------------------------------------------------

	function loadFields(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;* Cargando campos de tabla<br>";

		$counter = 0;

		foreach($this->index->children() as $field){
			
			$field_attributes = $field->attributes();
			$field_name = $field_attributes["name"];
			$field_type = $field_attributes["type"];
			$field_maxsize = $field_attributes["maxsize"];
			$field_key = $field_attributes["key"];
			$field_auto = $field_attributes["auto"];
			
			$metaField = new Field($field_name, $field_type, $field_maxsize, $field_key, $field_auto);
			$this->fields[] = $metaField;
			if($field_key == "PRIMARY"){
				$this->keyFields[] = $metaField;
				if($counter == 0){
					$counter = 1;
					$this->baseKey = $metaField;
				}
			}
						
		}

	}

//--------------------------------------------------------------------------------------------

	function loadTableAttributes(){
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;* Cargando tabla: ";
		
		$data = $this->index->attributes();
		$this->name = $data["name"];
		$this->total_fields = $data["fields"];
		$this->engine = $data["engine"];
		
		echo "$this->name<br>";
		
	}


//--------------------------------------------------------------------------------------------

	function check(){
	
		return 0;
		
	}

//--------------------------------------------------------------------------------------------

	function generate($bd){
		
		$objGenerator = new Maker($bd, $this);
		
		$objGenerator->generate();
				
	}

//--------------------------------------------------------------------------------------------

	
}


?>
