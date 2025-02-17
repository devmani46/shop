<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $stmt->execute([$cart_quantity, $cart_id]);
    
    $message[] = 'Cart quantity updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$delete_id]);
    
    header('location:cart.php');
    exit();
}

if (isset($_GET['delete_all'])) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    header('location:cart.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Shopping Cart</h3>
   <p> <a href="home.php">Home</a> / Cart </p>
</div>

<section class="shopping-cart">
   <h1 class="title">Products Added</h1>
   <div class="box-container">
      <?php
         $grand_total = 0;
         $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
         $stmt->execute([$user_id]);
         $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
         if ($cart_items) {
            foreach ($cart_items as $fetch_cart) {
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Delete this from cart?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">Rs <?php echo $fetch_cart['price']; ?>/-</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="Update" class="option-btn">
         </form>
         <div class="sub-total"> Sub Total: <span>Rs <?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      } else {
         echo '<p class="empty">Your cart is empty</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Delete all from cart?');">Delete All</a>
   </div>

   <div class="cart-total">
      <p>Grand Total: <span>Rs <?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">Continue Shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceed to Checkout</a>
      </div>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>