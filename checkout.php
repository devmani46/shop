<?php

include 'config.php'; // Include the config file which already contains the database connection

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

try {
   if (isset($_POST['order_btn'])) {
      $name = htmlspecialchars($_POST['name']);
      $number = $_POST['number'];
      $email = htmlspecialchars($_POST['email']);
      $method = htmlspecialchars($_POST['method']);
      $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
      $placed_on = date('d-M-Y');

      $cart_total = 0;
      $cart_products = [];

      // Fetch cart items
      $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
      $cart_query->execute(['user_id' => $user_id]);
      if ($cart_query->rowCount() > 0) {
         while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
         }
      }

      $total_products = implode(', ', $cart_products);

      // Check if the order already exists
      $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = :name AND number = :number AND email = :email AND method = :method AND address = :address AND total_products = :total_products AND total_price = :total_price");
      $order_query->execute([
         'name' => $name,
         'number' => $number,
         'email' => $email,
         'method' => $method,
         'address' => $address,
         'total_products' => $total_products,
         'total_price' => $cart_total
      ]);

      if ($cart_total == 0) {
         $message[] = 'your cart is empty';
      } else {
         if ($order_query->rowCount() > 0) {
            $message[] = 'order already placed!';
         } else {
            // Insert new order
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) 
                                          VALUES(:user_id, :name, :number, :email, :method, :address, :total_products, :total_price, :placed_on)");
            $insert_order->execute([
               'user_id' => $user_id,
               'name' => $name,
               'number' => $number,
               'email' => $email,
               'method' => $method,
               'address' => $address,
               'total_products' => $total_products,
               'total_price' => $cart_total,
               'placed_on' => $placed_on
            ]);
            $message[] = 'order placed successfully!';

            // Delete cart items after placing order
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
            $delete_cart->execute(['user_id' => $user_id]);
         }
      }
   }
} catch (PDOException $e) {
   die("Connection failed: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>Checkout</h3>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
      $select_cart->execute(['user_id' => $user_id]);
      if ($select_cart->rowCount() > 0) {
         while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   } else {
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" required placeholder="enter your number">
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" required placeholder="enter your email">
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method">
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paypal">Mobile Banking</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="street" required placeholder="e.g.  Dhobidhara Marg">
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" required placeholder="e.g. kathmandu">
         </div>
         <div class="inputBox">
            <span>province :</span>
            <input type="text" name="state" required placeholder="e.g. Bagmati ">
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" required placeholder="e.g. Nepal">
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 44600">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
