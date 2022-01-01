<?php
include "db_conn.php"; // Using database connection file here

if(isset($_POST['submit'])){
	 
	$email = $_POST["email"];	 
	$password = $_POST['password'];	 
	$user_data_query = mysqli_query($db,"SELECT * FROM user WHERE email= '$email' and password = '$password'");
	
	if (mysqli_num_rows($user_data_query) == 0){
		echo "Email or password is wrong";
		echo "<br>";
		echo '<a href="sign_in.html">Back to sign in</a>';
	}else{
		$user_data = mysqli_fetch_array($user_data_query);	

		$records = mysqli_query($db,"SELECT apple, beer, water, cheese FROM products");
		$product_price = mysqli_fetch_array($records);

		$rate_query = mysqli_query($db,"SELECT * FROM rate");
		$rate_data = mysqli_fetch_array($rate_query);
		$count = $rate_data['count'];
		if($rate_data['count'] == 0){
			$count = 1;	
		}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>HTML5</title>
  <style>
   table, th, td {
		border:1px solid black;
	}
	#email {
		display: none;
	}
	#previous_balance {
		display: none;
	}
  </style>
 </head>
 <body>
  <h2>Online shopping</h2>
<form action="update.php" method="POST" onsubmit="return check_activity_of_rbutton();">
	<label>Welcome <?php echo $user_data['email']; ?><label></br>
	<input type="text" name="email" id ="email" value=<?php echo $user_data['email']; ?>></br>
	<input type="text" name="previous_balance" id ="previous_balance" value=<?php echo $user_data['balance']; ?>></br>	
<div>	
	<table>
	<label>Price of products</label>	
	  <tr>
		<th>Apple</th>
		<th>Beer</th>
		<th>Water</th>
		<th>Cheese</th>
	  </tr>
	  <tr>
		<td><label id="store_apple"><?php echo $product_price['apple']; ?></label><label>$</label></td>
		<td><label id="store_beer"><?php echo $product_price['beer']; ?></label><label>$</label></td>
		<td><label id="store_water"><?php echo $product_price['water']; ?></label><label>$</label></td>
		<td><label id="store_cheese"><?php echo $product_price['cheese']; ?></label><label>$</label></td>
	  </tr>
		<tr>
		<td><button type="button" onclick="add_product()" id = "store_apple_add">Add</button></td>
		<td><button type="button" onclick="add_product()" id = "store_beer_add">Add</button></td>
		<td><button type="button" onclick="add_product()" id = "store_water_add">Add</button></td>
		<td><button type="button" onclick="add_product()" id = "store_cheese_add">Add</button></td>
	  </tr>  
	</table>
</div>  
<br>
<br>
<div>
	<table>
	<label>Rate of products</label>	
	  <tr>
		<th>Apple</th>
		<th>Beer</th>
		<th>Water</th>
		<th>Cheese</th>
	  </tr>

	  <tr>
		<td><label><?php echo round($rate_data['apple_rate']/$count,2); ?></label></td>
		<td><label><?php echo round($rate_data['beer_rate']/$count,2); ?></label></td>
		<td><label><?php echo round($rate_data['water_rate']/$count,2); ?></label></td>
		<td><label><?php echo round($rate_data['cheese_rate']/$count,2); ?></label></td>
	  </tr>
	</table>
</div>
<br>
<br>
<div>
	<label>You can rate the products here, please rate from 0 to 5</label>
	<table>
	  <tr>
		<th>Apple</th>
		<th>Beer</th>
		<th>Water</th>
		<th>Cheese</th>
	  </tr>    
	  <tr>	  
		 <td><input type="number" name="apple_rate" id ="apple_rate" min="0" max="5" onkeypress="return false;" value=0 required></td>
		 <td><input type="number" name="beer_rate" id ="beer_rate" min="0" max="5" onkeypress="return false;" value=0 required></td>
		 <td><input type="number" name="water_rate" id ="water_rate" min="0" max="5" onkeypress="return false;" value=0 required></td>
		 <td><input type="number" name="cheese_rate" id ="cheese_rate" min="0" max="5" onkeypress="return false;" value=0 required></td>    
	  </tr>
	</table>
</div>
<br>
<br>
<div>
	<label>Purchase</label>
	<table>
	  <tr>
		<th>Apple</th>
		<th>Beer</th>
		<th>Water</th>
		<th>Cheese</th>
	  </tr>    
	  <tr>	  
		 <td><input type="text" name="apple" id ="apple" value=0  readonly="true"></td>
		 <td><input type="text" name="beer" id ="beer" value=0 readonly="true"></td>
		 <td><input type="text" name="water" id ="water" value=0 readonly="true"></td>
		 <td><input type="text" name="cheese" id ="cheese" value=0 readonly="true"></td>    
	  </tr>    
	  <tr>
		<td><button type="button" onclick="remove_product()" id = "store_apple_remove">Remove</button></td>
		<td><button type="button" onclick="remove_product()" id = "store_beer_remove">Remove</button></td>
		<td><button type="button" onclick="remove_product()" id = "store_water_remove">Remove</button></td>
		<td><button type="button" onclick="remove_product()" id = "store_cheese_remove">Remove</button></td>
	  </tr>
	</table>
</div>
<br>
<div>
	<input type="radio" id="pick_up" name="radio" value="pick_up" onclick="radio_check()">Pick up
	<input type="radio" id="ups" name="radio" value="UPS($5)" onclick="radio_check()">UPS($5)
	<br>
	<label>Balance<label></br>
	<input type="text" name="balance" id ="balance" value=<?php echo $user_data['balance']; ?> readonly="true"></br>
	<label>Purchase<label></br>
	<input type="text" name="purchase" id ="purchase" value=0 readonly="true"></br>
	<input type="submit" name="submit"  value="Pay">
</div>
</form>

<script src="buy.js"></script>
<script src="remove.js"></script>
<script src="option.js"></script>
<script>
var rate_permission = <?php echo $user_data['rate']; ?>;

if(rate_permission == true){
	document.getElementById('apple_rate').readOnly = true;
	document.getElementById('beer_rate').readOnly = true;
	document.getElementById('water_rate').readOnly = true;
	document.getElementById('cheese_rate').readOnly = true;
}
</script>

 </body>
</html>

<?php
mysqli_close($db);
	}
}

?>