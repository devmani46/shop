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

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link href="./css/login.css" rel="stylesheet" type="text/css">
   <style>
    .side-button {
    border-radius: 20px;
    border: 1px solid #09376B;
    background-color: transparent;
    border-color:#FFFFFF;
    width:100%;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}
    </style>
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

    <div class="form-wrapper" id="formWrapper">
        <div class="form-section sign-in-section">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" value="Sign In" />
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error']; ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
        <div class="form-section sign-up-section">
            <form action="register.php" method="POST">
                <h1>Create an Account!</h1>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                <select name="user_type" class="box">
                <option value="user">User</option>
                <option value="admin">Admin</option>
                </select>
                <input type="submit" value="Sign Up" />

            </form>
        </div>
        <div class="overlay-wrapper">
            <div class="overlay">
                <div class="overlay-content overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To stay connected, please log in with your personal info.</p>
                    <button class="side-button" id="signInBtn">Sign In</button>
                </div>
                <div class="overlay-content overlay-right">
                    <h1>Hello!</h1>
                    <p>Enter your personal details to register with us.</p>
                    <button class="side-button" id="signUpBtn" >Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUpBtn');
        const signInButton = document.getElementById('signInBtn');
        const formWrapper = document.getElementById('formWrapper');

        signUpButton.addEventListener('click', () => {
            formWrapper.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            formWrapper.classList.remove("right-panel-active");
        });
    </script>
</body>
</html>
