<!DOCTYPE html>
<html>
<head>
<title>CicrometerPlus Gamer Store</title>
<style>
body {
    text-align: center;
}

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
}

table {
border-collapse: collapse;
width: 100%;
color: #588c7e;
font-family: monospace;
font-size: 25px;
text-align: left;
}
th {
background-color: #588c7e;
color: white;

}
td {
    cursor:pointer;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>




</head>
<body>

<div id="header"> CiromenterPlus Gamer PC Items</div>

<br>

<table>
<tr>
<th>Id</th>
<th>Name</th>
<th>Type</th>
<th>Price</th>
<th>Stock</th>
</tr>
<?php
$user = $_GET['user'];
$table = array();
$count = 1;
$conn = mysqli_connect("localhost", "root", "", "cicromenter");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT product.product_id, product.product_name, product_type.product_type_name, product.product_price, product.stock_amount FROM product INNER JOIN product_type ON product.product_type_id=product_type.product_type_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
    $table[$count] = $row;
    $count++;
    echo "<tr><td>" . $row["product_id"]. "</td><td>" . $row["product_name"] . "</td><td>"
    . $row["product_type_name"] . "</td><td>" . $row["product_price"] . "</td><td>" . $row["stock_amount"] . "</td></tr>";
}
echo "</table>";
} 

else { 
    echo "0 results"; 
}
$conn->close();
?>
</table>

<br><br><label for="fname">Welcome <b><?php echo $user?>!</b></label><br>

<br><label for="pid">Enter product id to add to cart:</label>
<input type="number" id="pid" name="pid">
<button onclick=addCart()>Add to cart</button><br><br>


<div id = "cartCount">
    Your cart items: <b>0</b>
</div>

<br>

<button id="button1" onclick=submit()>Proceed to checkout</button><br><br>

<script type="text/javascript">
    
    const items = [];
    var displayString = ""
    
    function addCart() {
        
        let id = document.getElementById("pid").value;

        let arr = <?php echo json_encode($table); ?>;
        let item = arr[id];

        items.push(item);
        
        displayString += arr[id]["product_name"] + ", ";
        document.getElementById("cartCount").innerHTML = "Your cart items: <b>" + items.length + " -> " + displayString + "</b>";
    }

    function submit() {
        let user = <?php echo json_encode($user); ?>;

        window.location = "./checkout.php?user=" + user + "&items=" + JSON.stringify(items);
    }

</script>

</body>