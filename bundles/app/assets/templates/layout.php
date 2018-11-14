<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<title>job — just do it</title>
	<link rel="shortcut icon" type="image/x-icon" href="http://<?=$_SERVER['SERVER_NAME']?>/favicon.ico" />
	<link rel="apple-touch-icon" sizes="144x144" href="http://<?=$_SERVER['SERVER_NAME']?>/apple-icon-144x144.png">
	<link rel="stylesheet" type="text/css" media="all" href="/uk/css/uikit.min.css">
	<link rel="stylesheet" type="text/css" media="all" href="/design/style.css"/>
	<script type="text/javascript" src="/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.drag.min.js"></script>
	<script type="text/javascript" src="/uk/js/uikit.min.js"></script>
	<script type="text/javascript" src="/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="/js/script.js"></script>
</head>
	<body>
		<header>
			<a href="/" class="uk-icon-rocket logo"></a>
			<ul class="uk-nav" id="hat-nav"><li><a href="/login" class="user">User</a></li></ul>
		</header>
		<?php $this->childContent();?>
	</body>
</html>