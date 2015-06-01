$(document).ready(function() {
	console.log('ready');

	$("#submit").click(function() {
		var username = $("#inputUsername").val();
		var password = $("#inputPassword").val();
		if (!username || !password) {
			console.log("username and password are required");
			return;
		}
		var data = {"username":username, "password":password};
		$.post("/ajax/login", data, function(result) {
			console.log(result);
			if (result.code == 0) {
				location.href = "/admin";
			} else {
				alert("用户名密码错误！");
			}
		}, "json");
	});
});