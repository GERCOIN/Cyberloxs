<?php
session_start();
error_reporting(0);
require('app/config.php');

$login = checkParam($_POST['login']);
$password = md5(checkParam($_POST['password']));

if($_SESSION["auth"] == true)
{
	header( 'Location: http://'. $config["server_addr"] .'/index', true, 301 );
	exit();
}

if ($login != null & $password != null)
{
	if($config["adm_login"] == $login & $config["adm_password"] == $password)
	{
		$_SESSION["auth"] = true;
		
		header( 'Location: http://'. $config["server_addr"] .'/index', true, 301 );
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
<!doctype html>
<html lang="en-us">
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Log in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600" rel="stylesheet">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="css/main.minffaf.css?v=1.4">
    </head>
    <body class="c-login-wrapper">
        <div class="c-login">
            <header class="c-login__head">
                <h1 class="c-login__title">Welcome back! Please login.</h1>
            </header>
            
            <form method="POST" action="" class="c-login__content">
                <div class="c-field u-mb-small">
                    <label class="c-field__label" for="input1">Login</label> 
                    <input class="c-input" type="text" id="input1" name="login" placeholder="root"> 
                </div>

                <div class="c-field u-mb-small">
                    <label class="c-field__label" for="input2">Password</label> 
                    <input class="c-input" type="password" id="input2" name="password" placeholder="toor"> 
                </div>

                <button class="c-btn c-btn--info c-btn--fullwidth" type="submit">Sign in to Dashboard</button>
            </form>
        </div>
    </body>
</html>