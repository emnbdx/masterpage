<?php

session_start();

define('__MASTERROOT__', dirname(dirname(__FILE__))); 
require_once(__MASTERROOT__.'/include/resources.php'); 

if(!isset($_SESSION["language"])) {
    $_SESSION["language"] = 'default';
}

if (isset($_GET['lang'])) {
    $_SESSION["language"] = $_GET['lang'];
}

/*
 * Localize text from resources.php file
 * Use this function localize(myvar) to localize according to session language 
 */
function localize($s) {   
	global $messages;
	
	if (isset($messages[$_SESSION["language"]][$s])) {
		return $messages[$_SESSION["language"]][$s];
	} else if (isset($messages['default'][$s])) {
		return $messages['default'][$s];
	} else {    
		error_log("l10n error:LANG:" . 
			$_COOKIE["language"] .",message:'$s'");
	}
}

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
	private function __construct($_rootPath) {
		$this->_rootPath = $_rootPath;
			
		//Now check if all menu exist, if not create empty page
		foreach(self::$_menuItem as $item) {
			$filename = $this->_rootPath . $item["page"];
		
			if (!file_exists($filename)) {
				$fp = fopen($filename, 'w');
				fwrite($fp, '<?php' . "\r\n");
				fwrite($fp, "\t" . 'define(\'__PAGEROOT__\', dirname(dirname(__FILE__)));' . "\r\n");
				fwrite($fp, "\t" . 'require_once(__PAGEROOT__.\'/include/masterpage.php\');' . "\r\n\r\n");
				fwrite($fp, "\t" . '$master = MasterPage::getInstance(\'..\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setTitle(\'' . localize($item["id"]) . '\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setCurrentPage(\'' . $item["id"] . '\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setHead(\'\');' . "\r\n");
				fwrite($fp, "\t" . '$master->setContent(0, ' . "\r\n");
				fwrite($fp, "\t\t" . '\'<div id="content">\'' . "\r\n");
				fwrite($fp, "\t\t\t" . '. localize(\'dummytext\') .' . "\r\n");
				fwrite($fp, "\t\t" . '\'</div>\');' . "\r\n");
				fwrite($fp, "\t" . '$master->display();' . "\r\n");
				fwrite($fp, '?>' . "\r\n");
				fclose($fp);
			}
		}
	}
	
	public static function getInstance($_rootPath) {
		if(is_null(self::$_instance)) {
			self::$_instance = new MasterPage($_rootPath);  
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

			echo '<link href="' . $this->_rootPath . '/style/global.css" rel="stylesheet" type="text/css" />';
			echo '<link href="http://fonts.googleapis.com/css?family=Jura:n,b,i,bi|Basic:n,b,i,bi" rel="stylesheet" type="text/css" />';
			echo '<style type="text/css">';
			echo '	.auto-style1 {';
			echo '		color: #FF00FF;';
			echo '	}';
			echo '</style>';
			
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
			
			echo '<script type="text/javascript">';
			echo "	var _gaq = _gaq || [];";
			echo "	_gaq.push(['_setAccount', 'UA-39477605-1']);";
			echo "	_gaq.push(['_trackPageview']);";
			
			echo "	(function() {";
			echo "		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
			echo "		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
			echo "		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
			echo "	})();";
			echo "</script>";
			
			echo $this->_head;
		echo '</head>';

		echo '<body>';
			echo '<table id="mainTable">';
				echo '<tr>';
					echo '<td id="langBar">';
					
					global $languages;
					foreach (array_keys($languages) as $language) {
						echo '	<a href="?lang=' . $language . '"><img width="50" height="50" src="' . $this->_rootPath . $languages[$language]["img"] . '" alt="'. $languages[$language]["alt"] . '" /></a>';
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
							echo '			<a id="'. $item["id"] . '" href="' . $this->_rootPath . $item["page"] . '">' . localize($item["id"]) . '</a></td>';
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
						echo $this->getContent(0);
						echo '<br>';
						echo $this->getContent(1);
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo '<footer>';
						echo '		<table>';
						echo '			<tr>';
						echo '				<td id="footerLeft">';
						echo '				© ' . date("Y") . ' by <a style="text-decoration: underline;" href="http://www.eddymontus.fr" target="_blank">Eddy MONTUS</a>';
						echo '				</td>';
						echo '				<td id="footerRight">';
						echo '					<a href="http://www.facebook.com" rel="nofollow" target="_blank">';
						echo '					<img height="25" src="' . $this->_rootPath . '/images/facebook.png" alt="facebook" width="25" /></a>';
						echo '					<a href="http://www.twitter.com" rel="nofollow" target="_blank">';
						echo '					<img src="' . $this->_rootPath . '/images/twitter.png" alt="twitter" width="25" height="25" /></a>';
						echo '				</td>';
						echo '			</tr>';
						echo '		</table>';
						echo '	</footer>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
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
	public function getContent($count) {
		if(isset($this->_content[$count])) {
			return $this->_content[$count];
		} else {
			return '';
		}
	}
	
	public function setContent($count, $content) {
		$this->_content[$count] = $content;
	}
}
?>