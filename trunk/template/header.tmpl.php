<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><? echo $pageName; ?> | Arkei</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600" rel="stylesheet">
	
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
	<link rel="stylesheet" href="css/main.min.css">
</head>
<body>
	<div class="c-toolbar u-mb-medium">
		<h3 class="c-toolbar__title has-divider"><? echo $pageName; ?></h3>
		<h5 class="c-toolbar__meta u-mr-auto">Arkei Stealer | v8.0.2 | Develop by <a href="https://t.me/foxovsky">@foxovsky</a> | <a href="/logout">Logout</a></h5>
		
		<script>
			function submit_handler(form)
			{
				document.getElementById('search').submit(); return false;
				return false;
			}
		</script>
		
		<form id="search" method="GET" action="/search" onsubmit="return submit_handler(this)">
		<div class="c-field has-icon-right c-navbar__search u-hidden-down@tablet u-ml-auto u-mr-small">
            <span class="c-field__icon">
                <i class="fa fa-search"></i> 
            </span>
               
            <label class="u-hidden-visually" for="navbar-search">Search</label>
            <input name="q" class="c-input" id="navbar-search" type="text" placeholder="Search">
        </div>
		</form>
		
		<a href="/index"><button type="button" class="c-btn c-btn--info u-ml-small" >Logs</button></a>	
		<a href="/profiles"><button type="button" class="c-btn c-btn--info u-ml-small" >Profiles</button></a>	
		<a href="/settings"><button type="button" class="c-btn c-btn--success u-ml-small" >Settings</button></a>	
	</div>