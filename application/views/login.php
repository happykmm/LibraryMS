<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>管理登录</title>
	<link rel="stylesheet" href="/css/init.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/login.css">
</head>
<body>
	<div class="container">

      <form class="form-signin" action="javascript:void(0)"> 
        <h2 class="form-signin-heading">管理员登录</h2>
        <label for="inputUsername" class="sr-only">用户名</label>
        <input type="username" id="inputUsername" class="form-control" placeholder="用户名" required autofocus>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="密码" required>
        <button id="submit" class="btn btn-lg btn-primary btn-block" type="submit">登&nbsp;录</button>
      </form>

    </div> <!-- /container -->

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/login.js"></script>
</body>
</html>