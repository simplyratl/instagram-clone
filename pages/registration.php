<?php
require('../db/conn.php');

$email = $username = $name = $password = $image = '';
$submitError = '';
$valid = true;

if (isset($_POST['submit'])) {

   $checkAdded = "SELECT * FROM users WHERE username='$username' OR email = '$email';";

   $resultCheck = $conn->query($checkAdded);

   if ($resultCheck->num_rows > 0) {
      $valid = false;
      $submitError = 'User with this email or username already exists.';
   }

   if ($valid) {

      $username = $_POST['username'];
      $name = $_POST['name'];


      $password = $_POST['password'];
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      $email = $_POST['email'];

      $target = "../uploads/avatars/" . basename($_FILES['image']['name']);
      $image = $_FILES['image']['name'];


      $sql = $conn->prepare("INSERT INTO users(email, fullname, username, password, profile_picture) VALUES(?, ?, ?, ?, ?);");
      $sql->bind_param("sssss", $email, $name, $username, $hashedPassword, $image);


      if ($sql->execute()) {
         if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $submitError = 'Registered succesfully, redirecting to login page.';
            header("refresh:3; url=login.php");
            mysqli_close($conn);
         } else {
            $submitError = 'Image has not been uploaded. Failed Registration.';
         }
      }

      $sql->close();
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
   <title>Register * Instagram</title>
</head>

<body>
   <div class="register-container">
      <div class="register-wrapper">
         <div class="top-bar">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/2560px-Instagram_logo.svg.png" class="logo" />

            <h3>Register so you can see photos and videos made by your friends.</h3>

            <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
               <div class="row">
                  <input type="email" placeholder="E-mail" name="email" id="email" autocomplete="off" />
                  <span id="emailErr"></span>
               </div>
               <span id="emailStatus" class="status"></span>

               <div class="row">
                  <input type="text" placeholder="Name and Surname" name="name" id="name" autocomplete="off" />
                  <span id="nameErr"></span>
               </div>
               <span id="nameStatus" class="status"></span>

               <div class="row">
                  <input type="text" placeholder="Username" name="username" id="username" autocomplete="off" />
                  <span id="usernameErr"></span>
               </div>
               <span id="usernameStatus" class="status"></span>

               <div class="row">
                  <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" />
                  <span id="passwordErr"></span>

               </div>
               <span id="passwordStatus" class="status"></span>

               <label for="image">Image</label>
               <div class="row">
                  <input type="file" name="image" />
               </div>

               <span style="font-size: 14px; font-weight: 600;"><?php echo $submitError; ?></span>

               <button type="submit" name="submit" class="register-btn" id="submit-btn" disabled='disabled'>Register</button>

               <span class="tos">If you register, you accept our Terms of Services and Cookie Policy.</span>
            </form>
         </div>

         <div class="already-registered">
            <span>Already have an account? <a href="login.php">Log in</a></span>
         </div>
      </div>
   </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/registration.js"></script>
</body>

</html>