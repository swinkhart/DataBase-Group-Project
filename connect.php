<?php

// Grab User submitted information
$username = $_POST["user"];
$password = $_POST["pass"];



// Create connection #servername, username, password, db 
$conn = mysqli_connect("localhost", "root", "","cicromenter");
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT email, userPassword  FROM user_account where email=? and userPassword=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();
$check = $result->fetch_assoc();


if(isset($check)){
	
	header("Location: ./store.php?user=".$username);

}

else
{
	echo 'Wrong Username or Password';
}




?>