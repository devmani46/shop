<?php

include 'config.php';  

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = htmlspecialchars($_POST['product_name']);
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Check if the product is already added to the cart
   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = :product_name AND user_id = :user_id");
   $check_cart_numbers->execute([
      'product_name' => $product_name,
      'user_id' => $user_id
   ]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'Already added to cart!';
   }else{
      // Insert the product into the cart
      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES(:user_id, :product_name, :product_price, :product_quantity, :product_image)");
      $insert_cart->execute([
         'user_id' => $user_id,
         'product_name' => $product_name,
         'product_price' => $product_price,
         'product_quantity' => $product_quantity,
         'product_image' => $product_image
      ]);
      $message[] = 'Product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

<div class="content">
   <h3>Top Tech, Handpicked for You!</h3>
   <p>Explore the latest smartphones, laptops, and smart gadgets – all at unbeatable prices. Upgrade your tech game today!</p>
   <a href="shop.php" class="white-btn">Shop Now</a>
</div>

</section>

<section class="products">

   <h1 class="title">Latest Products</h1>

   <div class="box-container">

      <?php  
         // Select the latest 6 products
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();

         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">Rs <?php echo $fetch_products['price']; ?>/-</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Load more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
      <h3>Why Choose ElectroMart?</h3>
      <p>At ElectroMart, we bring you the latest and greatest in technology with a seamless shopping experience. Whether you're looking for cutting-edge gadgets, high-performance accessories, or everyday electronics, we’ve got you covered.</p>
         <a href="about.php" class="btn">Read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Need Assistance? We're Here to Help!</h3>
      <p>Have questions about our products, orders, or warranty? Our team is ready to assist you with expert advice and quick support.</p>
      <a href="contact.php" class="white-btn">Contact Us</a>
   </div>

</section>


<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
