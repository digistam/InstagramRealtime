<?php
//gegevens voor toegang

$host = "127.0.0.1";
$user = "*****";
$password = "*****";
$dbname = "instagram";
$tablename = "media";

//verbinding opbouwen
$db = mysql_connect($host, $user, $password) or die("verbinding mislukt");
//database als standaard definiëren
mysql_select_db($dbname,$db);
?>
