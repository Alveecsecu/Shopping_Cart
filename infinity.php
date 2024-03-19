<?php 
@include 'config.php';

if(isset($_POST['update_update_btn'])){
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `carts` SET quantity = '$update_value' WHERE id = '$update_id'");
    if($update_quantity_query){
       header('location:infinity.php');
    };
 };
 
 if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `carts` WHERE id = '$remove_id'");
    header('location:infinity.php');
 };
 
 if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `carts`");
    header('location:infinity.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>

      <!-- font link--> 

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css file link --> 

    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>   
<div class="container">
    <section class="shopping-cart">
        <h1 class="heading">shopping cart</h1>

        <table>
             
            <thead>
                 <th>image</th>
                 <th>name</th>
                 <th>price</th>
                 <th>quantity</th>
                 <th>total price</th>
                 <th>action</th>
</thead>

<tbody>

   <?php 
     $select_cart = mysqli_query($conn,"SELECT *FROM `carts`");
     $grand_total = 0;
     if(mysqli_num_rows($select_cart)>0){
        while($fetch_cart = mysqli_fetch_assoc($select_cart)){

            ?>
              <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>   
            </td>
            <?php
            // Check if both price and quantity are numeric before calculating subtotal
            if (is_numeric($fetch_cart['price']) && is_numeric($fetch_cart['quantity'])) {
                $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                $grand_total += $sub_total;
                ?>
                <td>$<?php echo number_format($sub_total); ?>/-</td>
            <?php } else { ?>
                <td>Invalid input</td>
            <?php } ?>
            <td><a href="infinity.php?remove=<?php echo $fetch_cart['id']; ?>"
                   onclick="return confirm('remove item from cart?')" class="delete-btn"> <i
                            class="fas fa-trash"></i> remove</a></td>
        </tr>
        <?php
    }
}
?>
         <tr class="table-bottom">
            <td><a href="ind.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3">grand total</td>
            <td>$<?php echo $grand_total; ?>/-</td>
            <td><a href="infinity.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>


</tbody>


</table>
<div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>
       
</section>

</div>

<!-- Js link --> 
<script src="js/script.js"> </script>
</body>
</html>