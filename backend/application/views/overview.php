<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="#">

	<title>图书管理系统</title>
	<link rel="stylesheet" href="/css/init.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css" >
	<link rel="stylesheet" href="/css/console.css" >

</head>
<body>
	<?php include("console.php") ?>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        Welcome~
    </div>
	<script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
    	var active = '<?= basename(__FILE__,".php") ?>';
    </script>
    <script src="/js/console.js"></script>
</body>
</html>