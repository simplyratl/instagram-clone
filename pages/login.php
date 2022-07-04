<?php

require('../db/conn.php');

$username = $password = '';
$submitError = '';
$valid = true;

if (isset($_POST['submit'])) {
   if (!empty($_POST['username'])) {
      $username = $_POST['username'];
   }

   if (!empty($_POST['password'])) {
      $password = $_POST['password'];
   }

   $getUser = "SELECT * FROM users WHERE username='$username'";
   $resultUser = $conn->query($getUser);

   if ($resultUser->num_rows > 0) {
      $rowUser = $resultUser->fetch_assoc();

      if (password_verify($password, $rowUser['password'])) {
      } else {
         $valid = false;
      }
   } else {
      $valid = false;
   }


   if ($valid) {
      $sql = "SELECT * FROM users WHERE username = '$username'";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
         if ($row = $result->fetch_assoc()) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['id'];
            header('Location: index.php');
            mysqli_close($conn);
         }
      } else {
         $submitError = 'User not found.';
      }
   } else {
      $submitError = 'Incorrect password.';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://kit.fontawesome.com/f5f8362cf6.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="../style/dist/global.min.css" />
   <link rel="stylesheet" href="../style/dist/registration.min.css" />
   <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Instagram-Icon.png/769px-Instagram-Icon.png" type="image/png">
   <title>Login * Instagram</title>
</head>

<body>
   <div class="register-container">
      <div class="register-wrapper">
         <div class="top-bar">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/2560px-Instagram_logo.svg.png" class="logo" />

            <h3>Login so you can see photos and videos made by your friends.</h3>

            <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
               <div class="row">
                  <input type="username" placeholder="Username" name="username" id="username" autocomplete="off" value="<?php echo $username; ?>" />
               </div>

               <div class="row">
                  <input type="password" placeholder="Password" name="password" autocomplete="off" />
               </div>

               <span style="font-size: 14px; font-weight: 600;"><?php echo $submitError; ?></span>

               <button type="submit" name="submit" class="register-btn" id="submit-btn">Login</button>

               <span class="tos">If you login, you accept our Terms of Services and Cookie Policy.</span>
            </form>
         </div>

         <div class="already-registered">
            <span>Don't have an account? <a href="registration.php">Register</a></span>
         </div>
      </div>
   </div>
</body>

</html>