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
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>About us</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">

         <h3>Why Shop With Us?</h3>
         <p>1. Wide Selection of Electronics – From smartphones to smart home devices, we offer a vast collection of top-tier tech products.
            <br>2. Secure & Easy Shopping – Our platform ensures safe transactions and a hassle-free checkout process.
            <br>3. Fast & Reliable Delivery – Get your orders delivered quickly with real-time tracking.
            <br>4. 24/7 Customer Support – Our dedicated team is always here to assist you.
            <br>5. Exclusive Deals & Discounts – Enjoy competitive prices with special offers and seasonal discounts.
            <br>

Shop smart, shop tech – only at ElectroMart! </p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Client Reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.png" alt="Customer Image">
         <p>The wireless mouse I ordered works flawlessly! The ergonomic design is comfortable, and the battery life is impressive. Highly recommended for anyone looking for quality accessories!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Michael Smith</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="Customer Image">
         <p>I purchased a mechanical keyboard, and the typing experience is amazing! The RGB lighting is a great touch, and the build quality is top-notch. Will definitely shop here again.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Sarah Johnson</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="Customer Image">
         <p>Ordered a gaming headset, and the sound quality is fantastic! The noise cancellation works well, and the microphone is clear. Perfect for online meetings and gaming.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>David Lee</h3>
      </div>

      <div class="box">
         <img src="images/pic-4.png" alt="Customer Image">
         <p>The laptop I purchased exceeded my expectations. It's fast, lightweight, and perfect for both work and gaming. Customer support was very helpful too!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Emily Davis</h3>
      </div>

      <div class="box">
         <img src="images/pic-5.png" alt="Customer Image">
         <p>Great shopping experience! The power bank I ordered is compact yet powerful. It charges my devices quickly, making it a must-have for travel.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Robert Wilson</h3>
      </div>

      <div class="box">
         <img src="images/pic-6.png" alt="Customer Image">
         <p>Fast delivery and excellent product! The USB-C hub I got is very handy for connecting multiple devices. Solid build and works seamlessly.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Jessica Brown</h3>
      </div>

   </div>

</section>


<section class="authors">

   <h1 class="title">Team Members</h1>

   <div class="box-container">

      <div class="box">
         <img src="./images/team1.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Dev Mani Maharjan</h3>
      </div>

      <div class="box">
         <img src="./images/team2.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Aayush Shakya</h3>
      </div>

      <div class="box">
         <img src="./images/team3.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Aayush Singh Bista</h3>
      </div>

      <div class="box">
         <img src="./images/team4.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Romik Shrestha</h3>
      </div>

      <div class="box">
         <img src="./images/team5.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Jitendra Prasad Chaudhary</h3>
      </div>


   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>