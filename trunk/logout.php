<?php
session_start();
error_reporting(0);

require('app/config.php');

$_SESSION["auth"] = false;
header( 'Location: http://'. $config["server_addr"] .'/index', true, 301 );
exit(0);

?>