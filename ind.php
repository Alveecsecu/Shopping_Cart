<?php 
  
  @include 'config.php';
  if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE name = '$product_name'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `carts`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
      $message[] = 'product added to cart succesfully';
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <!-- font link--> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css file link --> 

    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 
if (!empty($message)) {
   foreach ($message as $msg) {
       echo '<div class="message"><span>'.$msg.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
   }
}

?>

<?php include 'header.php'; ?>

<div class="container">

<section class="products">
    <h1 class="heading">latest products</h1>
    <div class="box-container">

    <?php 
      $select_product = mysqli_query($conn,"SELECT * FROM `product`");
      if(mysqli_num_rows($select_product)>0){
        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            
       ?>
         
         <form action="" method="post">
            <div class="box">
                <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" height="250" alt="">
                <h3><?php echo $fetch_product['name']; ?></h3>
                <div class="price"><?php echo $fetch_product['price']; ?>/-</div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_product['idtt']?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']?>">
                <input type="submit" class="btn" value="add to cart" name="add_to_cart">
        </div>
        </form>

       <?php
        };
    };   

       ?>


</section>

</div>

<!-- Js link --> 
<script src="js/script.js"> </script>
    
</body>
</html>