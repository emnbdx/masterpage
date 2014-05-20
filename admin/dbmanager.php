<?php

class DdManager {
	private $_dbPath = '/db';
	private $_tables;
	
	public function isTable($file) {
		
	}

	public function getTables() {
		$files = scandir($_dbPath);
		foreach ($files -> $file) {
			if(isTable($file)) {
				$_tables.add($file);
			}
		}		
	}
	
	public function selectTable($tablename) {
	
	}
	
	public function deleteTable($tablename) {
	
	}
	
	public function updateTable($tablename) {
	
	}
}

?>