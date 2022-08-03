<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Create Account</title>
</head>
<center>
	<body>
    <style>

    #header {
        background-color: lightgreen;
        font-size: 40px;
    }
    </style>
		<div id="header">Create a new CicromenterPlus account</div>
        <br>
		<form method="post" action="account.php">
    		First Name : <input type="text" name="f_name" required><br><br>
            Last Name : <input type="text" name="l_name" required><br><br>
            Phone Number : <input type="number" name="phone" required><br><br>
            Email : <input type="text" name="email" required><br><br>
            Password : <input type="password" name="pass" required><br><br>
            Card Number : <input type="text" name="card_num" required><br><br>
            Zip Code : <input type="text" name="zip_code" required><br><br>
            Card Type : <select name="card_type" required> 
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>
    		<input type="submit" value="Create Account">
		</form>

	</body>
</center>
</html>