<?php

$pageName = "Log Viewer";

session_start();
error_reporting(0);

function convertToReadableSize($size)
{
  $base = log($size) / log(1024);
  $suffix = array(" B", " KB", " MB", " GB", " TB");
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

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

$log = checkParam($_GET["log"]);
$file = checkParam($_GET["file"]);
$action = checkParam($_GET["action"]);

if($log != NULL)
{
	if($file != null)
	{
		if($action == "download")
		{
			$zip = new ZipArchive;
			$reading = "";
			
			if ($zip->open('server/'.$config["logs_folder"].'/'. $log .'') === TRUE) 
			{
				$reading = $zip->getFromName($file);
				$zip->close();
				
				header('Content-type: application/zip');
				header('Content-Disposition: attachment; filename="'. $file .'"');
				header('Content-Length: ' . strlen($reading));
					
				echo $reading;
			} 
			else 
			{
				echo 'Error Reading File.';
			}
			
			exit(0);
		}
		
		if($file == "screenshot.bmp")
		{
			$z = new ZipArchive();
			
			//if ($zip->open('server/'.$config["logs_folder"].'/'. $log .'.zip') === TRUE) 
			if ($z->open('server/'.$config["logs_folder"].'/'. $log .'') !== true) {
				echo "File not found.";
				return false;
			}

			$stat = $z->statName($file);
			$fp   = $z->getStream($file);
			if(!$fp) {
				echo "Could not load image.";
				return false;
			}

			header('Content-Type: image/jpeg');
			header('Content-Length: ' . $stat['size']);
			fpassthru($fp);
			
			exit(0);
		}
		else
		{
			$zip = new ZipArchive;
			$reading = "";
			
			if ($zip->open('server/'.$config["logs_folder"].'/'. $log .'') === TRUE) 
			{
				$reading = $zip->getFromName($file);
				$zip->close();
					
				echo nl2br($reading);
			} 
			else 
			{
				echo 'Error Reading File.';
			}
			
			exit(0);
		}
	}
	else
	{
		$zip = zip_open('server/'.$config["logs_folder"].'/'. $log .'');
	}
}
else
{
	header( 'Location: http://'. $config["server_addr"] .'/index', true, 301 );
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
	 <div class="row u-mb-large">
                <div class="col-sm-12">
                    <table class="c-table">
                                <caption class="c-table__title"><? echo $log; ?></caption>
                                <thead class="c-table__head c-table__head--slim">
								<?php
								
								if(!$zip)
								{
									echo "Can't open log.";
									exit(0);
								}
								
								?>
                                    <tr class="c-table__row">
                                        <th class="c-table__cell c-table__cell--head">Size</th>
                                        <th class="c-table__cell c-table__cell--head">Name</th>
                                        <th class="c-table__cell c-table__cell--head">
                                            <span class="u-hidden-visually">Actions</span>
                                        </th>
										<th></th>
                                    </tr>
                                </thead>

                                <tbody>
								<?
								
								while ($zip_entry = zip_read($zip))
								{
									?>
									<tr class="c-table__row">
                                        <td class="c-table__cell"><span class="u-text-mute"><? echo  convertToReadableSize(zip_entry_filesize($zip_entry)); ?></span></td>
                                        <td class="c-table__cell"><? echo  zip_entry_name($zip_entry); ?></td>

                                        <td class="c-table__cell u-text-right">
										<?
										$_temp_name = substr(zip_entry_name($zip_entry),0,4);
										
										if($_temp_name == "cook")
										{
											?>
											<a class="c-btn c-btn--secondary" href="/convertToJSON?log=<? echo $log; ?>&file=<? echo zip_entry_name($zip_entry);?>">
												<i class="fa fa-pencil-square-o u-mr-xsmall"></i>Convert
											</a>
											
											<?
										}
										?>
										
                                            <a target="_blank" class="c-btn c-btn--info" href="/viewer?log=<? echo $log; ?>&file=<? echo  zip_entry_name($zip_entry); ?>" style="margin-left: 10px;margin-right: 10px;">
												<i class="fa fa-globe u-mr-xsmall"></i>Online View
											</a>
                                            <a target="_blank" class="c-btn c-btn--success" href="/viewer?log=<? echo $log; ?>&file=<? echo  zip_entry_name($zip_entry); ?>&action=download">
												<i class="fa fa-cloud-download u-mr-xsmall"></i>Download
											</a>
                                        </td>
                                        
                                    </tr>
									<?
								}
								
								?>
                                </tbody>
                            </table>
    </div>
				
    </div>
    </div>
	<script src="js/main.min.js?v=1.4"></script>
    </body>
</html>
<?php zip_close($zip); ?>