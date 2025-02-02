<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pending = $conn->prepare("SELECT total_price FROM `orders` WHERE payment_status = 'pending'");
            $select_pending->execute();
            $pending_orders = $select_pending->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($pending_orders as $order) {
                $total_pendings += $order['total_price'];
            }
         ?>
         <h3>Rs. <?php echo $total_pendings; ?>/-</h3>
         <p>Total Pendings</p>
      </div>

      <div class="box">
         <?php
            $total_completed = 0;
            $select_completed = $conn->prepare("SELECT total_price FROM `orders` WHERE payment_status = 'completed'");
            $select_completed->execute();
            $completed_orders = $select_completed->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($completed_orders as $order) {
                $total_completed += $order['total_price'];
            }
         ?>
         <h3>Rs. <?php echo $total_completed; ?>/-</h3>
         <p>Completed Payments</p>
      </div>

      <div class="box">
         <?php 
            $select_orders = $conn->query("SELECT COUNT(*) FROM `orders`");
            $number_of_orders = $select_orders->fetchColumn();
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Order Placed</p>
      </div>

      <div class="box">
         <?php 
            $select_products = $conn->query("SELECT COUNT(*) FROM `products`");
            $number_of_products = $select_products->fetchColumn();
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p>Products Added</p>
      </div>

      <div class="box">
         <?php 
            $select_users = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE user_type = 'user'");
            $select_users->execute();
            $number_of_users = $select_users->fetchColumn();
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>Normal Users</p>
      </div>

      <div class="box">
         <?php 
            $select_admins = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE user_type = 'admin'");
            $select_admins->execute();
            $number_of_admins = $select_admins->fetchColumn();
         ?>
         <h3><?php echo $number_of_admins; ?></h3>
         <p>Admin Users</p>
      </div>

      <div class="box">
         <?php 
            $select_account = $conn->query("SELECT COUNT(*) FROM `users`");
            $number_of_account = $select_account->fetchColumn();
         ?>
         <h3><?php echo $number_of_account; ?></h3>
         <p>Total Accounts</p>
      </div>

      <div class="box">
         <?php 
            $select_messages = $conn->query("SELECT COUNT(*) FROM `message`");
            $number_of_messages = $select_messages->fetchColumn();
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>New Messages</p>
      </div>

   </div>

</section>

<!-- admin dashboard section ends -->

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
