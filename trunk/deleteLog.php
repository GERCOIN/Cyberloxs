<?php
/*
	Main Page
*/
session_start();
error_reporting(0);

require("app/config.php");

if($config["db_server"] == null)
{
	header('Location: http://'. $_SERVER["HTTP_HOST"] .'/install');
	exit(0);
}

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["server_addr"] .'/auth', true, 301 );
	exit(0);
}

$logID = checkParam($_GET["id"]);
$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	if($logID != null)
	{
		$log = $database->query("SELECT * FROM `logs` WHERE `id`='$logID';")->fetch_array();
		
		if($log["id"] != null)
		{
			$fpath = "server/". $config["logs_folder"]."/". $bot["user"];
			unlink($fpath);
			
			$database->query("DELETE FROM `logs` WHERE `id`='$logID'");
		}
		
		header('Location: http://'. $_SERVER["HTTP_HOST"] .'/index');
	}
}
else
{
	echo "Can't connect to MySQL";
	exit(0);
}

mysqli_close($database);

function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
} 
 
?>