<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $pass = md5($_POST['pass']);
   $cpass = md5($_POST['cpass']);

   $image = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_size = $_FILES['image']['size'];
   $image_folder = 'uploads/' . basename($image); 

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:index.php');
         }
      }
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
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    </head>

    <body>

        <?php
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

        <section class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Register Now</h3>
                <input type="text" required placeholder="Enter your username" class="box" name="name">
                <input type="email" required placeholder="Enter your email" class="box" name="email">
                <input type="password" required placeholder="Enter your password" class="box" name="pass">
                <input type="password" required placeholder="Confirm your password" class="box" name="cpass">
                <input type="file" name="image" required class="box" accept="image/jpg, image/png, image/jpeg">
                <p>Already have an account? <a href="index.php">Login now</a></p>
                <input type="submit" value="Register Now" class="btn" name="submit">
            </form>
        </section>

    </body>

</html>