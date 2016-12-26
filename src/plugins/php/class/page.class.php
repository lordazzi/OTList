<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 13/11/12 #

class Page {
	public $account;
	
	public function __construct($login = FALSE) {
		if ($login == TRUE) {
			redirect("/index.php?".urlCompile());
		} else {
			$this->account = new Account();
		}
		
		$js = Page::getMirror("js");
		if (file_exists($js)) {
			Page::add("js", $url);
		} 
		
		$css = Page::getMirror("css");
		if (file_exists($css)) {
			Page::add("css", $url);
		}
		
		require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/php/incs/header.php");
		require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/php/incs/menu.php");
	}
	
	public function __destruct() {
		require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/php/incs/footer.php");
	}
	
	/** função que mostra qual o arquivo espelho */
	public static function add($type, $url) {
		if ($types == "js") {
			echo("<script type='text/javascript' src='$url'></script>");
		}
		
		if ($types == "css") {
			echo("<link rel='stylesheet' type='text/css' href='$url' />");
		}
	}
	
	public static function getMirror($type) {
		$file = get_file_noext($_SERVER["PHP_SELF"]);
		return "/mirror/$type$file.$type";
	}
	
	public static function unpathed($evoke) {
		$ext = get_file_ext($evoke);
		switch ($ext) {
			case "js":
				echo("<script type='text/javascript' src='/mirror/$ext/unpathed/$evoke'></script>");
				break;
			case "css":
				echo("<link rel='stylesheet/less' type='text/css' href='/mirror/$ext/unpathed/$evoke' />");
				break;
			case "php":
				require_once($_SERVER["DOCUMENT_ROOT"]."/mirror/$ext/unpathed/$evoke");
				break;
		}
	}
}
?>