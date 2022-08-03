
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
</head>
<body>
<style>
            b {
                background-color: yellow;
                border-style: dashed;
            }

            body {
                text-align: center;
                font-size:30px;
            }

            #header {
    			background-color: lightgreen;
    			font-size: 40px;
				text-align:center;
			}
</style>
<div id="header">Ready to Checkout?</div>
<br>
</body>
<?php

##---------------------------------------------------------------------------##
    // Create connection #servername, username, password, db 
    $conn = mysqli_connect("localhost", "root", "", "cicromenter");
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $email = $_GET['user'];
    $sql = "SELECT first_name FROM user_account where email=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $name = $result->fetch_assoc()['first_name'];

    echo "".$name.", your cart contains:<br><br><b>";
    //$_GET['items'] retrieves the items added to cart with their product name and id
    //to get the id or product name do $_GET['items']['product_id']
    $arr = json_decode($_GET['items'], true);
    for ($x = 0; $x <= count($arr)-1; $x++){
	if($x == count($arr)-1){
            echo str_replace('"', '',json_encode($arr[$x]['product_name']));
        }else{
            echo str_replace('"', '',json_encode($arr[$x]['product_name'])).", ";
        }
        
    }
    echo "</b>";

    $total_price= 0;
    //Adds all product prices together for the total cost in cart
    for ($p = 0; $p <= count($arr)-1; $p++){
       $total_price +=  str_replace('"', ' ',json_encode($arr[$p]['product_price'])) + 0;

    }
    echo "<br><br>Total price is: <b>$".$total_price."</b><br>";

    if(array_key_exists('complete', $_POST)){
        completeOrder();
    }

    function handleTransaction(){
        $email = $_GET['user'];
        $date = date("n/j/Y");
        $products = $_GET['items'];
        $arr = json_decode($_GET['items'], true);
        $total_price = 0;
        for ($p = 0; $p <= count($arr)-1; $p++){
            $total_price +=  str_replace('"', ' ',json_encode($arr[$p]['product_price'])) + 0;
     
         }

        $conn = mysqli_connect("localhost", "root", "", "cicromenter");
        if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        get_id_number:
        $transaction_id_number = rand(1000000000, 9999999999);
        //check to see if transaction id is already in the system
        $sql = "SELECT transaction_id FROM user_transaction WHERE transaction_id = $transaction_id_number";
        $result = $conn->query($sql);

        if($result->num_rows == 0){

            //update the user_transaction table with the information provided
            
            /*
            $sql = "INSERT INTO user_transaction (transaction_id, email, product_id, purchase_date, cost) 
                VALUES ($transaction_id_number, $email, $product_id, $date, $total_price)";
            $conn->query($sql);
            */

            
            $stmt = $conn->prepare("INSERT INTO user_transaction VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $transaction_id_number, $email, $date, $total_price);
            $stmt->execute();
            

            //update the transaction_product table with the information provided
            foreach ($arr as $prod_id){
                $id = str_replace('"', ' ',json_encode($prod_id['product_id']));
                $transaction_product_update = "INSERT INTO transaction_product VALUES ($transaction_id_number, $id)";
                $conn->query($transaction_product_update);
            }
        }
        else {
            goto get_id_number;
        }

        //Keep at bottom of function
        header("Location: ./store.php?user=".$email);
    }

    function completeOrder(){

        $conn = mysqli_connect("localhost", "root", "","cicromenter");
         // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT card_number FROM user_payment where email=?";
        $email = $_GET['user'];
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $result = $stmt->get_result();

        if($result->num_rows == 0){
            echo "<br>No payment info";
        }else{
            $cardNumber = substr($result->fetch_assoc()['card_number'], -4);
            echo "<br>Card Number: ************".$cardNumber;
            handleTransaction();

        }
        
       

    }

?>
<br>
<form method="post">
    <input type="submit" name="complete" value="Complete Order"/>
</form>
</html>