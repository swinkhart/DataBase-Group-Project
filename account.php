<?php

// Grab User submitted information

$firstname = $_POST["f_name"];
$lastname = $_POST["l_name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["pass"];
$cardNum = $_POST["card_num"];
$zipCode = $_POST["zip_code"];
$cardType = $_POST["card_type"];

// Create connection #servername, username, password, db 
$conn = mysqli_connect("localhost", "root", "","cicromenter");
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT count(email) FROM user_account where email=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$check = $result->fetch_assoc();


if($check["count(email)"] > 0){
	
    echo "<script>alert(\"account already exists.\");window.location = \"./account_create.php\";</script>";
}

else
{
	$sql = "INSERT INTO user_account VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $email, $firstname, $lastname, $phone, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    $sql = "INSERT INTO user_payment VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $cardNum, $email, $zipCode, $cardType);
    $stmt->execute();

    $result = $stmt->get_result();

    if(!$result){
        echo "<script>alert(\"account successfully created\");window.location = \"./login.php\";</script>";    
    }

}
?>