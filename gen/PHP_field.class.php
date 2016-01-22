<?php

class Field{
	var $name;
	var $type;
	var $maxsize;
	var $key;
	var $auto;

//--------------------------------------------------------------------------------------------

	function __construct($name, $type, $maxsize, $key, $auto){
		
		$this->name = $name;
		$this->type = $type;
		$this->maxsize = $maxsize;
		$this->key = $key;
		$this->auto = $auto;
		
	}


//--------------------------------------------------------------------------------------------

}
