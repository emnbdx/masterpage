<?php
	require_once('include/masterpage.php');
	
	$master = MasterPage::getInstance('.');
	$master->setTitle('E.M. Réparation');
	$master->setCurrentPage('index');
	$master->setContent(
		'<div id="content">
			<img height="54" src="images/arrow.png" alt="fleche" style="position: absolute; left: 28px; top: 73px;" width="64">
			<div id="homeMainMessage" style="left: 116px; top: 25px">
				"Marre des prestations hors de prix et souvent inefficaces laissez-moi prendre soin de votre matériel et pour un résultat certain."
			</div>
			<div style="position: absolute; width: 860px; height: 279px; top: 199px; left: 60px; background-image: url(\'images/black_50.png\'); font-family: Basic, sans-serif; font-size: 14px;">
				<div style="width: 200px; height: 35px; background-color: #000000; font-size: 18px; color: #FF00FF; text-align: center; vertical-align: middle; line-height: 100%; display: table-cell;">
					Les Services
				</div>
				<div style="width: 620px; height: 170px; position: relative; top: 20px; left: 40px">
					Pourquoi changer de pc et dépenser environ 500€ alors que le votre est encore en état de marche?<br>
					Une simple réinitialisation permet de rendre à votre pc une seconde jeunesse et sans perte de données.
					﻿<br>Avec l\'arrivée des smartphones et tablettes de nouvelles pannes ont vu le jour dont le fameux écran cassé.
					﻿<br>﻿<br>
					Je vous propose donc 3 axes de réparation:<br>
					&nbsp;- Les pc (portable ou tour)<br>
					&nbsp;- Les téléphones portables (iPhone, Sony)<br>
					&nbsp;- Les tablettes
				</div>
			</div>
		</div>');
	$master->display();
?>