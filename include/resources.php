<?php

/*
 * Array of available languages and flags to display on web site 
 */
$languages = array (
	'default' => array(
		'img' => '/images/flag/large/France.png',
		'alt' => 'FR'
	),
	'en' => array(
		'img' => '/images/flag/large/UnitedKingsom.png',
		'alt' => 'EN'
	)
);

/*
 * Array of localized string
 */
$messages = array (
    'default' => array(
        'index' => 'Accueil',
        'price' => 'Tarifs',
        'me' => 'Qui suis-je?',
        'contact' => 'Contact',
        'work' => 'Réalisations',
		
		'text' => 'Ceci est un texte localisé',
		'dummytext' => 'Ceci est un text auto généré',
		'category1' => 'Catégorie 1',
    ),
    
    'en' => array(
		'index' => 'Home',
        'price' => 'Price',
        'me' => 'Who am I?',
        'contact' => 'Contact',
        'work' => 'Work',
		
		'text' => 'This is a localized text',
		'dummytext' => 'This is an auto generated page',
		'category1' => 'Category 1',
    )
);

?>
