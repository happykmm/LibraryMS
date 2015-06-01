var app = angular.module('LoginApp', [])
.controller('LoginController', function ($scope, $http) {
	$scope.credentials = {
		username: '',
		password: ''
	};
	$scope.login = function (credentials) {
		console.log(credentials);
		$http.post("/backend/ajax/login", credentials)
		.success(function (response) {
            if (response.code != 0) {
            	alert(response.desc);
            } else {
            	location.href = "/console.html";
            }
        })
        .error(function (data, status, headers, config) {
            console.log(data);
            console.log(status);
        });
	};
});