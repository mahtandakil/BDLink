<?php

// BDLinker - PHP PDO class creator 0.9.4
// Config file

class BDLConfig{
	var $BDDataHost;
	var $BDDataName;
	var $BDDataUser;
	var $BDDataPass;

	function __construct(){
		$this->BDDataHost = 'localhost';
		$this->BDDataName = 'ead';
		$this->BDDataUser = 'root';
		$this->BDDataPass = 'nuitadenui';
	}

}

?>