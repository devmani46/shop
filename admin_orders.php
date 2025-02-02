<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    $update_query = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_query->execute([$update_payment, $order_update_id]);

    $message[] = 'Payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delete_query = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_query->execute([$delete_id]);

    header('location:admin_orders.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Placed Orders</h1>

   <div class="box-container">
      <?php
      $select_orders = $conn->query("SELECT * FROM `orders`");

      if ($select_orders->rowCount() > 0) {
         while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
         <p> User ID : <span><?php echo htmlspecialchars($fetch_orders['user_id']); ?></span> </p>
         <p> Placed on : <span><?php echo htmlspecialchars($fetch_orders['placed_on']); ?></span> </p>
         <p> Name : <span><?php echo htmlspecialchars($fetch_orders['name']); ?></span> </p>
         <p> Number : <span><?php echo htmlspecialchars($fetch_orders['number']); ?></span> </p>
         <p> Email : <span><?php echo htmlspecialchars($fetch_orders['email']); ?></span> </p>
         <p> Address : <span><?php echo htmlspecialchars($fetch_orders['address']); ?></span> </p>
         <p> Total Products : <span><?php echo htmlspecialchars($fetch_orders['total_products']); ?></span> </p>
         <p> Total Price : <span>Rs. <?php echo htmlspecialchars($fetch_orders['total_price']); ?>/-</span> </p>
         <p> Payment Method : <span><?php echo htmlspecialchars($fetch_orders['method']); ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo htmlspecialchars($fetch_orders['payment_status']); ?></option>
               <option value="pending">Pending</option>
               <option value="completed">Completed</option>
            </select>
            <input type="submit" value="Update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
         </form>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No orders placed yet!</p>';
      }
      ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
