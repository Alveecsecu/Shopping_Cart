<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM carts");
   $price_total = 0;
   $product_name = []; // Initialize an empty array to store product names
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         // Ensure both price and quantity are numeric before calculation
         if(is_numeric($product_item['price']) && is_numeric($product_item['quantity'])) {
            $product_price = $product_item['price'] * $product_item['quantity'];
            $price_total += $product_price;
         } else {
            die('Invalid price or quantity encountered');
         }
      };
   };

   $total_product = implode(', ',$product_name);
   // Use prepared statements to prevent SQL injection
   $detail_query = mysqli_prepare($conn, "INSERT INTO order(name, number, email, method, flat, street, city, state, country, pin_code, total_product, total_price) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die('query failed');
   mysqli_stmt_bind_param($detail_query, "ssssssssssss", $name, $number, $email, $method, $flat, $street, $city, $state, $country, $pin_code, $total_product, $price_total);
   mysqli_stmt_execute($detail_query);

   if(mysqli_stmt_affected_rows($detail_query) > 0){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>thank you for shopping!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : $".$price_total."/-  </span>
         </div>
         <div class='customer-details'>
            <p> your name : <span>".$name."</span> </p>
            <p> your number : <span>".$number."</span> </p>
            <p> your email : <span>".$email."</span> </p>
            <p> your address : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
            <p> your payment mode : <span>".$method."</span> </p>
            <p>(pay when product arrives)</p>
         </div>
            <a href='ind.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
   } else {
      echo "Failed to place order. Please try again.";
   }

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- Font link --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CSS file link --> 
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    
<section class="checkout-form">

<h1 class="heading">complete your order</h1>

<form action="" method="post">

<div class="display-order">
   <?php
      $select_cart = mysqli_query($conn, "SELECT * FROM carts");
      $total = 0;
      $grand_total = 0;
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            // Ensure both price and quantity are numeric before calculation
            if(is_numeric($fetch_cart['price']) && is_numeric($fetch_cart['quantity'])) {
               $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
               $grand_total = $total += $total_price;
               ?>
               <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
               <?php
            } else {
               die('Invalid price or quantity encountered');
            }
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
   ?>
   <span class="grand-total"> grand total : $<?= $grand_total; ?>/- </span>
</div>

   <div class="flex">
      <div class="inputBox">
         <span>your name</span>
         <input type="text" placeholder="enter your name" name="name" required>
      </div>
      <div class="inputBox">
         <span>your number</span>
         <input type="number" placeholder="enter your number" name="number" required>
      </div>
      <div class="inputBox">
         <span>your email</span>
         <input type="email" placeholder="enter your email" name="email" required>
      </div>
      <div class="inputBox">
         <span>payment method</span>
         <select name="method">
            <option value="cash on delivery" selected>cash on delivery</option>
            <option value="credit cart">credit cart</option>
            <option value="paypal">paypal</option>
         </select>
      </div>
      <div class="inputBox">
         <span>address line 1</span>
         <input type="text" placeholder="e.g. flat no." name="flat" required>
      </div>
      <div class="inputBox">
         <span>address line 2</span>
         <input type="text" placeholder="e.g. street name" name="street" required>
      </div>
      <div class="inputBox">
         <span>city</span>
         <input type="text" placeholder="e.g. mumbai" name="city" required>
      </div>
      <div class="inputBox">
         <span>state</span>
         <input type="text" placeholder="e.g. maharashtra" name="state" required>
      </div>
      <div class="inputBox">
         <span>country</span>
         <input type="text" placeholder="e.g. india" name="country" required>
      </div>
      <div class="inputBox">
      <span>pin code</span>
         <input type="text" placeholder="e.g. 123456" name="pin_code" required>
      </div>
   </div>
   <input type="submit" value="order now" name="order_btn" class="btn">
</form>


</section>
</div>
    

<!-- Js link --> 
<script src="js/script.js"> </script>
</body>
</html>
