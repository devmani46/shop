<?php

include 'config.php';  

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = htmlspecialchars($_POST['name']);
   $email = htmlspecialchars($_POST['email']);
   $number = $_POST['number'];
   $msg = htmlspecialchars($_POST['message']);

   // Check if the message already exists in the database
   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = :name AND email = :email AND number = :number AND message = :message");
   $select_message->execute([
      'name' => $name,
      'email' => $email,
      'number' => $number,
      'message' => $msg
   ]);

   if($select_message->rowCount() > 0){
      $message[] = 'Message sent already!';
   }else{
      // Insert the message into the database
      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(:user_id, :name, :email, :number, :message)");
      $insert_message->execute([
         'user_id' => $user_id,
         'name' => $name,
         'email' => $email,
         'number' => $number,
         'message' => $msg
      ]);
      $message[] = 'Message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Contact Us</h3>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>Say something!</h3>
      <input type="text" name="name" required placeholder="Enter your name" class="box">
      <input type="email" name="email" required placeholder="Enter your email" class="box">
      <input type="number" name="number" required placeholder="Enter your number" class="box">
      <textarea name="message" class="box" placeholder="Enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Send Message" name="send" class="btn">
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
