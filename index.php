<?php
	require_once('include/masterpage.php');
	
	$master = MasterPage::getInstance('.');
	$master->setTitle('');
	$master->setCurrentPage('index');
	$master->setContent(
		'<div id="content">
			<img height="54" src="images/arrow.png" alt="fleche" style="position: absolute; left: 28px; top: 73px;" width="64">
			<div id="homeMainMessage" style="left: 116px; top: 25px">'
				. localize("text") .
			'</div>
			<div style="position: absolute; width: 860px; height: 279px; top: 199px; left: 60px; background-image: url(\'images/black_50.png\'); font-family: Basic, sans-serif; font-size: 14px;">
				<div style="width: 200px; height: 35px; background-color: #000000; font-size: 18px; color: #FF00FF; text-align: center; vertical-align: middle; line-height: 100%; display: table-cell;">'
					. localize("category1") .
				'</div>
				<div style="width: 620px; height: 170px; position: relative; top: 20px; left: 40px">
					BLA BLA BLA<br/><br/>
					BLA BLA
				</div>
			</div>
		</div>');
	$master->display();
?>