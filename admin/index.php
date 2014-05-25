<?php
require_once('dbmanager.php');

$manager = new DbManager();

$tables = $manager->getTables();

foreach($tables as $table)
	$manager->selectTable($table);

?>