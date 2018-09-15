<?php

session_start();
error_reporting(0);

$pageName = "Search";

require("app/config.php");
require "app/searchEngine.php";

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

$query = $_GET["q"];//checkParam($_GET["q"]);

if($query != null)
{
	
}
else
{
	header('Location: http://'. $_SERVER["HTTP_HOST"] .'/index');
	exit(0);
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
                    <table class="c-table u-mb-small">

                        <caption class="c-table__title">Found by <? echo $query; ?><small>  <a href="/faq?type=search">How to use search?</a></small></caption>

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
							<? SearchEngine($query, $config); ?>
						</tbody>
                    </table>
                </div>
            </div>
			<script src="js/main.min.js?v=1.4"></script>
	</div>
</div>