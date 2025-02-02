<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   // Sanitize user inputs to avoid XSS
   $email = htmlspecialchars($_POST['email']);
   $pass = md5($_POST['password']); // Consider using a more secure hashing method in the future, like bcrypt

   // Prepare and execute query to check if the user exists
   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
   $select_users->execute([
      'email' => $email,
      'password' => $pass
   ]);

   // Check if a user was found
   if($select_users->rowCount() > 0){

      $row = $select_users->fetch(PDO::FETCH_ASSOC);

      // Check user type and create session variables accordingly
      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');
      }elseif($row['user_type'] == 'user'){
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
      }

   }else{
      $message[] = 'Incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
// Display any messages (e.g., incorrect login)
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="submit" value="Login Now" class="btn">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
   </form>

</div>

</body>
</html>
