<?php

define('_ROOT_', dirname(dirname(__FILE__))); 

$languages = array (
	'fr_FR.utf8' => array(
		'img' => '/images/flag/large/France.png',
		'alt' => 'FR'
	),
	'en_US.utf8' => array(
		'img' => '/images/flag/large/UnitedKingsom.png',
		'alt' => 'EN'
	)
);

if(!isset($_SESSION["language"])) {
    $_SESSION["language"] = 'fr_FR.utf8';
}

if (isset($_GET['lang'])) {
    $_SESSION["language"] = $_GET['lang'];
}

$locale = $_SESSION["language"];
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", _ROOT_ . "/locale");
textdomain("messages");

?>