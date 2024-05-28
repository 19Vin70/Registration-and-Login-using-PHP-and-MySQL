<?php
session_start();
include 'config.php';

if(isset($_POST['submit'])) {
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $pass = md5($_POST['pass']); 

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select->execute([$email, $pass]);
   $row = $select->fetch(PDO::FETCH_ASSOC);

   if($select->rowCount() > 0) {
      if($row['user_type'] == 'user') {
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
      } else {
         $message = 'No user found!';
      }
   } else {
      $message = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration and Login using PHP and MySQL</title>
        <!-- <link rel="stylesheet" href="css/style.css"> -->
        <link rel="stylesheet" href="css/style.css?v=<?=time();?>">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    </head>

    <body>
        <?php if(isset($message)): ?>
        <div class="message">
            <span><?= $message ?></span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        <?php endif; ?>

        <section class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Login Now</h3>
                <input type="email" required placeholder="Enter your email" class="box" name="email">
                <input type="password" required placeholder="Enter your password" class="box" name="pass">
                <p>Don't have an account? <a href="register.php">Register now</a></p>
                <input type="submit" value="Login Now" class="btn" name="submit">
            </form>
        </section>
    </body>

</html>