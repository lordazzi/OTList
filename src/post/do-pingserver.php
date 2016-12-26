<?php
# AUTHOR: RICARDO AZZI #
#  CREATED: 13/02/2013   #
echo("/*");
$GLOBAL["count"] = FALSE;
ini_set("max_execution_time", 30);
set_time_limit(30);
require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/config.php");

$sql = new MySql("otlist");

$serverinfo = getServer($_POST["ip"], $_POST["port"]);
$id = $_POST["idserver"];
$motd = $_POST["motd"];
$serverinfo["motd"] = $serverinfo["motd"];
print_r($serverinfo);

if ($serverinfo["code"] == 200) {
	$sql->Query("UPDATE servers SET nrpeak=".$serverinfo["players"]["peak"].", txtrealip='".$serverinfo["serverinfo"]["ip"]."' WHERE idserver=$id"); //	atualizando ip e o máximo de jogadores que já jogaram este server
	$sql->Query("UPDATE servers_online_history SET iscurrent=0 WHERE server=$id");	//	avisando que o ultimo servidor inserido não é mais o atual
	$sql->Query("INSERT INTO servers_online_history (idserver, nronline, nrcode, nruptime, dtcadastro) VALUES ($id, ".$serverinfo["players"]["online"].", 200, ".$serverinfo["serverinfo"]["uptime"].", NOW())"); //	inserindo as novas informações no servidor
	
	//	verificando se existe um MOTD
	if ($motd <> "") {
		if ($serverinfo["motd"] <> $motd AND $motd <> "") {
			$sql->Query("UPDATE server_modt SET islatest=0 WHERE idserver=$id");
			$sql->Query("INSERT INTO server_modt (idserver, txtmotd, islatest, dtcadastro) VALUES ($id, '$motd', 1, NOW())");
		}
	//	se não existir motd, ele tem permissão de cadastrar
	} else if ($motd <> "") {
		echo("INSERT INTO server_modt (idserver, txtmotd, islatest, dtcadastro) VALUES ($id, '$motd', 1, NOW())");
		$sql->Query("INSERT INTO server_modt (idserver, txtmotd, islatest, dtcadastro) VALUES ($id, '$motd', 1, NOW())");
	}
} else { // outros
	if ($serverinfo["code"] == 404) {
		$sql->Query("UPDATE servers SET isread = 1 WHERE idserver=$id");
	}
	$sql->Query("INSERT INTO servers_online_history (idserver, nronline, nrcode, dtcadastro) VALUES ($id, 0, ".$serverinfo["code"].", NOW())");
}

echo("*/");
if ($serverinfo)
	callback($serverinfo);
?>