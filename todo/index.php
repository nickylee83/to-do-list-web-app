<?php
// index.php

session_start();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>My To-do Application Register & Login</title>
		<!-- bootstrap library -->
		<link href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel = "stylesheet">
		<!-- angular library -->
		<script src = "http://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
		<style>
			.form_style{
				width: 600px;
				margin: 0 auto;
			}

		</style>
	</head>
	<body>
		<br />
		<h3 align = "center"><strong>My To-do Application Register & Login</strong></h3>
		<br />
		
		<!-- application structure -->
		<div ng-app = "login_register_app" ng-controller = "login_register_controller" class = "container form_style">
			<?php
			// if user not login to the system
			//if(isset($_SESSION["name"]))
			//{
			?>
			<div class = "alert {{alertClass}} alert-dimissible" ng-show = "alertMsg">
				<a href = "#" class = "close" ng-click = "closeMsg()" aria-label = "close">&times;</a>
				{{alertMessage}}
			</div>
			
			<!-- login form starts here -->
			<div class = "panel panel-primary" ng-show= "login_form">
				<!-- heading -->
				<div class= "panel-heading">
					<h3 class= "panel-title" ng-style = "mainHead">Login</h3>
				</div>
				<!-- login form body -->
				<div class = "panel-body">
					<form method = "post" ng-submit = "submitLogin()">
						<div class= "form-group">
							<label>Enter your email</label>
							<input type= "text" name="email" ng-model = "loginData.email" class = "form-control" ng-style = "textBox" />
						</div>

						<div class= "form-group">
							<label>Enter your password</label>
							<input type= "password" name="password" ng-model = "loginData.password" class = "form-control" ng-style = "textBox" />
						</div>

						<div class= "form-group" align = "center">
							<!-- login submit button -->
							<input type= "submit" name="login" class = "btn btn-primary" value = "Login" />
							<!-- link to register -->
							<input type= "button" name= "register_link" class= "btn btn-primary btn-link" ng-click= "showRegister()" value= "Register" />
						</div>

					</form>
				</div>
			</div>
			<!-- register form starts here -->
			<div class="panel panel-primary" ng-show= "register_form">
				<!-- heading -->
				<div class = "panel-heading">
					<h3 class= "panel-title" ng-style= "mainHead">Register</h3>
				</div>
				<!-- body of the register form -->
				<div class= "panel-body">
					<form method = "post" ng-submit= "submitRegister()">
						<div class= "form-group">
							<label>Enter your name</label>
							<input type= "text" name="name" ng-model = "registerData.name" class = "form-control" ng-style = "textBox" />
						</div>

						<div class= "form-group">
							<label>Enter your email</label>
							<input type= "text" name="email" ng-model = "registerData.email" class = "form-control" ng-style = "textBox" />
						</div>

						<div class= "form-group">
							<label>Enter your password</label>
							<input type= "password" name="password" ng-model = "registerData.password" class = "form-control" ng-style = "textBox" />
						</div>
						<!-- register submit button -->
						<div class= "form-group" align= "center">
							<input type= "submit" name="register" class = "btn btn-primary" value = "Register" />
							<!-- link to login -->
							<input type= "button" name= "login_link" class= "btn btn-primary btn-link" ng-click= "showLogin()" value= "Login" />
						</div>
					</form>
				</div>
			</div>
			<?php
			//}
			//else
			//{
			?>
			<!--div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Welcome to the System</h3>
				</div>

				<div class = "panel-body">
					<h1>Welcome - <?php echo "name";?></h1>
					<a href = "logout.php">Logout</a>
				</div>
			</div-->
			<?php
			//}
			?>			
		</div>
	</body>
</html>

<script>
	var app = angular.module('login_register_app',[]);
	app.controller('login_register_controller',function($scope,$http){
		// hide the alert message
		$scope.closeMsg = function(){
			$scope.alertMsg = false;
		};
		// show login form on page load
		$scope.login_form = true;
		// display register form
		$scope.showRegister = function(){
			$scope.login_form = false;
			$scope.register_form = true;
			$scope.alertMsg = false;
		};
		// display login form
		$scope.showLogin = function(){
			$scope.register_form = false;
			$scope.login_form = true;
			$scope.alertMsg = false;
		};

		// main heading CSS
		$scope.mainHead = {
			"color" : "#FFFFFF",
			"font-weight" : "bold",
        	"padding" : "5px"
		}
		
		// text box CSS
		$scope.textBox = {
			"border-radius" : "15px",
			"padding" : "5px",
			"margin" : "5px"
		}

		// submit registered data
		$scope.submitRegister = function(){
			$http({
				method:"POST", url:"register.php",
				data:$scope.registerData
				// data submitted successfully
			}).success(function(data){
				$scope.alertMsg = true;
				if(data.error != ''){
					// data validation error
					$scope.alertClass = 'alert-danger';
					$scope.alertMessage = data.error;
				}
				else{
					// no errors
					$scope.alertClass = 'alert-success';
					$scope.alertMessage = data.message;
					// clear text boxes
					$scope.registerData = {};
				}
			});
		};
		// submit login data
		$scope.submitLogin = function(){
			$http({
				method:"POST",url:"login.php",
				data:$scope.loginData
				// data submitted successfully
			}).success(function(data){

				if(data.error != ''){
					// data validation error
					$scope.alertMsg = true;
					$scope.alertClass = 'alert-danger';
					$scope.alertMessage = data.error;
				} else {
					// no errors and correct password
					window.location = "index.html";
				}
			});
		};
	});
</script>