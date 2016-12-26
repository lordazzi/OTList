<?php
# AUTHOR: RICARDO AZZI #
#  CREATED: 13/02/2013   #
$GLOBAL["count"] = FALSE;
require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/config.php");

$sql = new MySql("otlist");
$servers = $sql->Query("
	SELECT
		a.idserver, a.txtip, b.txtmotd, a.nrport
	FROM servers a
	LEFT JOIN server_modt b ON a.idserver = b.idserver AND b.islatest = 1
	WHERE a.isactive = 1 AND a.isread = 0");
callback(array(
	"servers" => $servers
));

?>