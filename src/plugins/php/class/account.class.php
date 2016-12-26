<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 13/11/12 #

class Account {
	private $sql;
	private $tries;
	
	public function __construct() {
	}
	
	private function reload() {
		return TRUE;
	}
	
	public function isLogin() {
		return TRUE;
	}
	
	public function doLogin($login, $senha, $captcha) {
		return TRUE;
	}
	
	public function doLogout() {
		return TRUE;
	}
	
	public function isCaptcha() {
		return TRUE;
	}
	
	public function getTries() {
		return TRUE;
	}
	
	public function getUserData() {
		return TRUE;
	}
}

?>