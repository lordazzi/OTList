<?php

class Server {
	public $idserver;
	public $idaccount;
	public $txtname;
	public $txtpropaganda;
	public $txtwebsite;
	public $nrpeak;
	public $txtcountry;
	
	public $nrxp;
	public $nrskills;
	public $nrml;
	public $nrloot;
	
	public $txtip;
	public $nrtype;
	public $txttype;
	public $txtversion;
	public $txtdescription;
	public $nronline;
	public $nruptime;
	public $dtcadastro;
	
	private $sql;
	
	public function __construct($configs) {
		$sql = new MySql("otlist");
		if (gettype($configs) == "integer") { // id do servidor
			$configs = $sql->Query("SELECT 	
				a.idserver, a.idaccount, a.txtname, a.txtpropaganda, a.txtwebsite,
				a.txtip a.nrpeak, a.txtcountry, a.nrxp, a.nrml, a.nrskills, a.nrloot,
				a.nrtype, b.txttype, a.txtversion, a.txtdescription, c.nronline,
				c.nruptime, c.dtcadastro
				FROM servers a
				INNER JOIN servers_type b ON a.nrtype = b.idtype
				LEFT JOIN servers_online_history c ON a.idserver = c.idserver AND c.iscurrent=1
				WHERE a.isactive=1 AND a.idserver = $configs");
			$configs = $configs[0];
		}
		
		if (gettype($configs) == "array") { // array do record
			$this->idserver = $configs["idserver"];
			$this->idaccount = $configs["idaccount"];
			$this->txtcountry = $configs["txtcountry"];
			
			$this->txtname = $configs["txtname"];
			$this->txtpropaganda = $configs["txtpropaganda"];
			$this->txtwebsite = $configs["txtwebsite"];
			$this->txtip = $configs["txtip"];
			
			$this->nrxp = $configs["nrxp"];
			$this->nrskills = $configs["nrskills"];
			$this->nrml = $configs["nrml"];
			$this->nrloot = $configs["nrloot"];
			
			$this->nrtype = $configs["nrtype"];
			$this->txttype = $configs["txttype"];
			$this->txtversion = $configs["txtversion"];
			
			$this->nronline = $configs["nronline"];
			$this->nrpeak = $configs["nrpeak"];
			$this->txtdescription = $configs["txtdescription"];
			$this->nruptime = $configs["nruptime"];
			$this->dtcadastro = $configs["dtcadastro"];
		} else {
			throw new Exception("Parâmetro inválido passado");
		}
	}
	
	public function getLink() {
		$web = $this->txtwebsite;
		$ip = $this->txtip;
		if ($web <> "") {
			return "<a href='$web' title='Ir para: $web' target='_BLANK'>$web</a>";
		} else {
			return "<a href='serverinfo.php?s=".$this->idserver."' title='Este servidor não tem um website cadastrado'>$ip</a>";
		}
	}
	
	public function getUptime($style = "int") {
		if ($this->nruptime <> 0) {	
			$up = $this->nruptime + (time() - $this->dtcadastro);
			if ($style == "int") {
				return $up;
			} else if ($style == "string") {
				$h = floor($up / 60 / 60);
				$m = floor($up / 60 % 60);
				$s = floor($up % 60 % 60);
				$d = floor($h / 24);
				$h = $h % 24;
				if ($d <> 0) {
					return $d."d ".$h."h ".$m."m ".$s."s";
				} else if ($d <> 0) {
					return $h."h ".$m."m ".$s."s";
				} else if ($h <> 0) {
					return $m."m ".$s."s";
				}			
			}
		} else {
			return "0"; // se o servidor estiver offline, retorne zero
		}
	}
	
	public function getFlag() {
		return "http://www.timetravel.net.br/otlist/plugins/img/flags/thumb_".strtolower($this->txtcountry).".gif";
	}
}
?>