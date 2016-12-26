<?php
# AUTHOR: RICARDO AZZI #
#  CREATED: 13/02/2013   #
$GLOBAL["count"] = FALSE;
require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/config.php");

$sql = new MySql("otlist");
$sql->Query("UPDATE servers SET isread=0");
?>