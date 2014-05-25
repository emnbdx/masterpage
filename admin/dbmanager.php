<?php

class DbManager {
	private $_dbPath = '../db/';
	private $_tables = array();
	
	public function isTable($file) {
		return substr($file, -strlen(".xml")) === ".xml";
	}

	public function getTables() {
		$files = scandir($this->_dbPath);
		foreach ($files as $file) {
			if($this->isTable($file)) {
				$this->_tables[] = $file;
			}
		}

		return $this->_tables;
	}
	
	public function selectTable($tablename) {
		$fileName = $this->_dbPath . $tablename;
	
		$reader = new XMLReader();
		$reader->open($fileName);
		
		while($reader->read()){
			echo $reader->name . "<br/>";
			echo $reader->value . "<br/>";
		}
	}
	
	public function deleteTable($tablename) {
	
	}
	
	public function updateTable($tablename) {
	
	}
}

?>