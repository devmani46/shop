<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit;
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   
   $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
   $delete_stmt->execute([$delete_id]);
   
   header('location:admin_users.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom Admin CSS File Link -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">
   <h1 class="title">User Accounts</h1>
   <div class="box-container">
      <?php
         $select_stmt = $conn->prepare("SELECT * FROM users");
         $select_stmt->execute();
         $users = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
         
         foreach ($users as $user) {
      ?>
      <div class="box">
         <p> User ID: <span><?php echo htmlspecialchars($user['id']); ?></span> </p>
         <p> Username: <span><?php echo htmlspecialchars($user['name']); ?></span> </p>
         <p> Email: <span><?php echo htmlspecialchars($user['email']); ?></span> </p>
         <p> User Type: <span style="color:<?php echo ($user['user_type'] == 'admin') ? 'var(--orange)' : '#000'; ?>;">
            <?php echo htmlspecialchars($user['user_type']); ?></span> 
         </p>
         <a href="admin_users.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete User</a>
      </div>
      <?php
         }
      ?>
   </div>
</section>

<!-- Custom Admin JS File Link -->
<script src="js/admin_script.js"></script>

</body>
</html>
