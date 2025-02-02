<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = $conn->prepare("DELETE FROM `message` WHERE id = ?");
    $delete_query->execute([$delete_id]);
    header('location:admin_contacts.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> messages </h1>

   <div class="box-container">
   <?php
      $select_message = $conn->query("SELECT * FROM `message`");
      if ($select_message->rowCount() > 0) {
         while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <div class="box">
      <p> user id : <span><?php echo htmlspecialchars($fetch_message['user_id']); ?></span> </p>
      <p> name : <span><?php echo htmlspecialchars($fetch_message['name']); ?></span> </p>
      <p> number : <span><?php echo htmlspecialchars($fetch_message['number']); ?></span> </p>
      <p> email : <span><?php echo htmlspecialchars($fetch_message['email']); ?></span> </p>
      <p> message : <span><?php echo htmlspecialchars($fetch_message['message']); ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete message</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">you have no messages!</p>';
      }
   ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
