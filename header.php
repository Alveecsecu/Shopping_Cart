<header class="header">

<div class="flex">
    <a href="#" class="logo">foodies</a>

    <nav class="navbar">

    <a href="login.php">login</a>
      <a href="admin.php">add product</a>
      <a href="ind.php">view product</a>
   
     </nav>

     <?php
      
      $select_rows = mysqli_query($conn, "SELECT * FROM `carts`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>

     <a href="infinity.php" class="Cart">Cart<span><?php echo $row_count; ?></span> </a>

     <div id="menu-btn" class="fas fa-bars"></div>





</div>




</header>