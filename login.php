<?php

include 'config.php';
session_start();

if (isset($_POST['submit'])) {

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, ($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {

      $row = mysqli_fetch_assoc($select_users);

      if ($row['user_type'] == 'admin') {

         $_SESSION['admin_name'] = $row['username'];
         // $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id_user'];
         header('location:admin_page.php');
      } 
      elseif ($row['user_type'] == 'user') {

         $_SESSION['user_name'] = $row['username'];
         // $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id_user'];
         header('location:admin_page.php');
      }
   } else {
      $message[] = 'incorrect email or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


   <style>
      body {
         height: 100%;
      }

      .container-login {
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;
      }
      .card{
         padding: 10px;         
      }
      
   </style>
</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <div class="container-login mt-5">


      <div class="card" style="width: 30rem;">

         <form action="" method="post">
            <h3 class="text-center">login</h3>
            <div class="mb-3 w-auto">
               <label class="form-label">Username</label>
               <input type="text" class="form-control" name="username" aria-describedby="emailHelp">
               <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3 w-auto">
               <label class="form-label">Password</label>
               <input type="password" class="form-control" name="password" aria-describedby="emailHelp">
               <div id="passwordHelp" class="form-text">We'll never ask your password.</div>
            </div>

            <div class="col text-center">
            <button type="submit" class="btn btn-primary text-center" name="submit">Login</button>
            <p class="pt-2">don't have an account? <a href="register.php">register now</a></p>
            </div>
         </form>
      </div>
   </div>

</body>

</html>