<?php

session_start();

require_once('configuration.php');
require_once('localization.php');

class MasterPage {

	private static $_instance;
	/*
	 * Define all menu here, go to http://localhost/index.php and all file will create immediately on 'contenu' folder
	 * Then you have to complete function setHead(''); with css or javascript code
	 * and function setContent(''); with HTML code
	 */
	private static $_menuItem = array(array("id" => "index",
											"page" => "/index.php"), 
									array("id" => "price",
											"page" => "/contenu/tarifs.php"), 
									array("id" => "me",
											"page" => "/contenu/qui-suis-je.php"), 
									array("id" => "contact",
											"page" => "/contenu/contact.php"), 
									array("id" => "work",
											"page" => "/contenu/realisations.php"));
											
	private $_rootPath;
	private $_title;
	private $_currentPage;
	private $_head;
	private $_content = array();
	
	/*
	 * Define css class to apply on menu
	 */
	private function getClass($objId) {
		if($objId == $this->_currentPage) {
			return "current";
		} else {
			return "non_current";
		}
	}
	
	/*
	 * Constructor with all parameter, display function can be called immediately
	 */
	private function __construct() {			
		//Now check if all menu exist, if not create empty page
		foreach(self::$_menuItem as $item) {
			$filename = dirname(dirname(__FILE__)) . $item["page"];
		
			if (!file_exists($filename)) {
				$fp = fopen($filename, 'w');
				fwrite($fp, '<?php' . "\r\n");
				fwrite($fp, "\t" . 'require_once(\'../include/masterpage.php\');' . "\r\n\r\n");
				fwrite($fp, "\t" . '$master = MasterPage::getInstance();' . "\r\n");
				fwrite($fp, "\t" . '$master->setTitle(\'' . _($item["id"]) . '\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setCurrentPage(\'' . $item["id"] . '\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setHead(\'\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setContent("contenu1", ' . "\r\n");
				fwrite($fp, "\t\t" . '\'<div id="content">\'' . "\r\n");
				fwrite($fp, "\t\t\t" . '. _("dummytext") .' . "\r\n");
				fwrite($fp, "\t\t" . '\'</div>\');' . "\r\n");
				fwrite($fp, "\t" . '$master->display();' . "\r\n");
				fwrite($fp, '?>' . "\r\n");
				fclose($fp);
			}
		}
	}
	
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new MasterPage();  
		}
		
		$_title = '';
		$_currentPage = '';
		$_head = '';
		$_content = array();
 
		return self::$_instance;
	}
	
	/*
	 * Display all html code on using parameter passed
	 */
	public function display() {
		echo '<!DOCTYPE html>';
		echo '<html>';
		echo '<head>';
			echo '<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />';
			echo '<meta name="keywords" content="" />';
			echo '<meta name="description" content="" />';
			echo "<title>$this->_title</title>";

			echo '<link href="' . __ROOT__ . '/style/global.min.css" rel="stylesheet" type="text/css" />';
			echo '<link href="http://fonts.googleapis.com/css?family=Jura:n,b,i,bi|Basic:n,b,i,bi" rel="stylesheet" type="text/css" />';
			echo '<style type="text/css">';
			echo '	.auto-style1 {';
			echo '		color: #FF00FF;';
			echo '	}';
			echo '</style>';
			
			echo $this->_head;
		echo '</head>';

		echo '<body>';
			echo '<table id="mainTable">';
				echo '<tr>';
					echo '<td id="langBar">';
					
					global $languages;
					foreach (array_keys($languages) as $language) {
						echo '	<a href="?lang=' . $language . '"><img width="50" height="50" src="' . __ROOT__ . $languages[$language]["img"] . '" alt="'. $languages[$language]["alt"] . '" /></a>';
					}
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo '<header>';
						echo '		<div id="menu">';
						echo '			<table>';
						echo '			<tr>';
						
						foreach(self::$_menuItem as $item) {
							echo '		<td class="' . $this->getClass($item["id"]) . '" width="' . (100 / count(self::$_menuItem)) . '%">';
							echo '			<a id="'. $item["id"] . '" href="' . __ROOT__ . $item["page"] . '">' . _($item["id"]) . '</a></td>';
							echo '		</td>';
						}
						echo '			</tr>';
						echo '		</table>';
						echo '		</div>';
						echo '		<div id="title">';
						echo '			<span class="auto-style1">Mon</span> Site';
						echo '		</div>';
						echo '	</header>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo $this->getContent("contenu1");
						echo '<br>';
						echo $this->getContent("contenu2");
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo '<footer>';
						echo '		<table>';
						echo '			<tr>';
						echo '				<td id="footerLeft">';
						echo '				© 2012 - ' . date("Y") . ' by <a style="text-decoration: underline;" href="http://www.eddymontus.fr" target="_blank">Eddy MONTUS</a>';
						echo '				</td>';
						echo '				<td id="footerRight">';
						echo '					<a href="http://www.facebook.com" rel="nofollow" target="_blank">';
						echo '					<img height="25" src="' . __ROOT__ . '/images/facebook.png" alt="facebook" width="25" /></a>';
						echo '					<a href="http://www.twitter.com" rel="nofollow" target="_blank">';
						echo '					<img src="' . __ROOT__ . '/images/twitter.png" alt="twitter" width="25" height="25" /></a>';
						echo '				</td>';
						echo '			</tr>';
						echo '		</table>';
						echo '	</footer>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';

			echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
			echo '<script type="text/javascript">';
			echo '$(document).ready(function() {';
			echo '	$("#content").hide();';
			echo ' 	$("#content").fadeIn(1000);';
			echo '	$("a.transition").click(function(event){';
			echo '		event.preventDefault();';
			echo '		linkLocation = this.href;';
			echo '		$("#content").fadeOut(500, redirectPage);';	
			echo '	});';
					
			echo '	function redirectPage() {';
			echo '		window.location = linkLocation;';
			echo '	}';
			
			echo '});';
			echo '</script>';
			
			echo '<script>';
		  	echo '	(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
		  	echo '	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
		  	echo '	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
		  	echo '	})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';
		  	echo '	ga(\'create\', \'UA-40535132-1\', \'auto\');';
		  	echo '	ga(\'send\', \'pageview\');';
			echo '</script>';

			echo $this->getContent("script");

		echo '</body>';

		echo '</html>';
	}
	
	/*
	 * Page title used in <head><title>...
	 */
	public function getTitle() {
		return $this->_title;
	}
	
	public function setTitle($title) {
		$this->_title = $title;
	}
	
	/*
	 * Current page name, used to define menu style
	 */
	public function getCurrentPage() {
		return $this->_currentPage;
	}
	
	public function setCurrentPage($currentPage) {
		$this->_currentPage = $currentPage;
	}
	
	/*
	 * Head, this will contain script, css. 
	 */
	public function getHead() {
		return $this->_head;
	}
	
	public function setHead($head) {
		$this->_head = $head;
	}
	
	/*
	 * Content to display in page, it might be HTML code
	 */
	public function getContent($key) {
		if(isset($this->_content[$key])) {
			return $this->_content[$key];
		} else {
			return '';
		}
	}
	
	public function setContent($key, $content) {
		$this->_content[$key] = $content;
	}
}
?>