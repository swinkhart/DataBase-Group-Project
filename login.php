<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Login</title>
</head>
<center>
	<body>
		<style>
			button {
    			background-color: green;
    			color: white;
				font-size: 20px;
			}

			button:hover {
    			background-color: yellow;
    			color: black;
			}

			#header {
    			background-color: lightgreen;
    			font-size: 40px;
				text-align:center;
			}

		</style>
		<div id="header"> Welcome to CicromenterPlus, please log in.</div>
		<br>
		<form method="post" action="connect.php">
  	 	 Username : <input type="text" name="user"><br><br>
    		Password : <input type="password" name="pass"><br><br>
    		<input type="submit" value="Login">
		</form>
		<br><br>
		<button onclick="createAccount()">Create New Account</button>

	<script>
		function createAccount() {
			window.location = "./account_create.php";
		}
	</script>

	</body>
</center>
</html>