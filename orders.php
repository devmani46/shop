<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Your Orders</h3>
</div>

<section class="placed-orders">

   <h1 class="title">Placed Orders</h1>

   <div class="box-container">

      <?php
         // Prepare query to fetch orders for the current user
         $order_query = $conn->prepare("SELECT * FROM `orders` WHERE user_id = :user_id");
         $order_query->execute(['user_id' => $user_id]);

         if($order_query->rowCount() > 0){
            while($fetch_orders = $order_query->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
         <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
         <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
         <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
         <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
         <p>Payment Method: <span><?php echo $fetch_orders['method']; ?></span></p>
         <p>Your Orders: <span><?php echo $fetch_orders['total_products']; ?></span></p>
         <p>Total Price: <span>$<?php echo $fetch_orders['total_price']; ?>/-</span></p>
         <p>Payment Status: 
            <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;">
               <?php echo $fetch_orders['payment_status']; ?>
            </span>
         </p>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">No orders placed yet!</p>';
         }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
