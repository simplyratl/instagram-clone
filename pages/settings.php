<?php
require('../db/conn.php');

if (isset($_GET['username'])) {
   $usernameProfile = $_GET['username'];
} else {
   header("Location: index.php");
}

if ($_SESSION['username'] != $_GET['username'] && $_SESSION['id'] != 1) {
   header("Location: index.php");
}

// if ($usernameProfile != $_SESSION['username']) {
//    header('Location: index.php');
// }
$username = $pictureUploadSuccess = $profilePage = $name = $idUser = '';

$req = "SELECT * FROM users WHERE username = '$usernameProfile'";
$resultReq = $conn->query($req);

while ($row = $resultReq->fetch_assoc()) {
   $profilePage = $row['profile_picture'];
   $name = $row['fullname'];
   $idUser = $row['id'];
   $username = $row['username'];
}

$loggedInUser = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'";
$resultLoggedInUser = $conn->query($loggedInUser);
$rowLoggedInUser = $resultLoggedInUser->fetch_assoc();


if (isset($_POST['download-btn'])) {
   $file = fopen('../uploads/reports/' . $rowLoggedInUser['username'] . '.txt', 'w') or die('Unable to open file.');
   $text = "ID: " . $rowLoggedInUser['id'] . "\r\n" . "Username: " . $rowLoggedInUser['username'] . "\r\n" . "Email: " . $rowLoggedInUser['email'] . "\r\n" . "Full Name: " . $rowLoggedInUser['fullname'] . "\r\n" . "Password: " . $rowLoggedInUser['password'];
   fwrite($file, $text);
   fclose($file);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://kit.fontawesome.com/f5f8362cf6.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="../style/dist/main.min.css" />
   <link rel="stylesheet" href="../style/dist/global.min.css" />
   <link rel="stylesheet" href="../style/dist/profile.min.css" />
   <link rel="stylesheet" href="../style/dist/settings.min.css" />
   <link rel="stylesheet" href="../style/dist/spinner.css" />
   <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Instagram-Icon.png/769px-Instagram-Icon.png" type="image/png">
   <title><?php echo $usernameProfile ?> * Instagram</title>
</head>

<body>
   <div class="main-container">
      <div class="navbar-container">
         <div class="navbar-wrapper">

            <div class="navbar-logo">
               <a href="index.php">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/2560px-Instagram_logo.svg.png" />
               </a>
            </div>

            <div class="search-container">
               <i class="fa-solid fa-magnifying-glass"></i>
               <div class="search-input">
                  <input type="text" placeholder="Search" id='search' autocomplete="off" />
                  <div class="lds-ring" id="search-load">
                     <div></div>
                     <div></div>
                     <div></div>
                     <div></div>
                  </div>
               </div>

               <div class="suggestions" id="suggestions">
                  <ul class="suggestion-list" id="suggestion-list">
                  </ul>
               </div>
            </div>

            <div class="control-container">
               <i class="fa-solid fa-house element icon"></i>
               <div class="chat element">
                  <span class="notifications">10</span>
                  <i class="fa-regular fa-comment icon"></i>
               </div>

               <i class="fa-solid fa-circle-plus icon element" style="font-size: 1.8rem;" id="add-post" onclick="openAddPost()"></i>

               <div class="avatar-image" onclick="openUserSettings()" id="user-avatar">
                  <img src="../uploads/avatars/<?php echo $rowLoggedInUser['profile_picture']; ?>" class="user-avatar element" />

                  <div class="sub-menu" id="sub-menu">
                     <ul>
                        <a href="profile.php?username=<?php echo $rowLoggedInUser['username']; ?>">
                           <li>
                              <i class="fa-regular fa-user"></i>
                              Profile
                           </li>
                        </a>
                        <a href="#">
                           <li>
                              <i class="fa-solid fa-gear"></i>
                              Settings
                           </li>
                        </a>
                        <a href="logout.php">
                           <li class="logout">
                              Logout
                           </li>
                        </a>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="settings-container">
         <h1>Settings</h1>

         <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="downloading-report">
               <span class="download-files">Download report about your profile.</span>

               <button type="submit" class="download-btn-report" name="download-btn">Download</button>
            </div>
         </form>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="../js/main.js"></script>
      <script src="../js/search.js"></script>
      <script>
         if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
         }
      </script>
</body>

</html>

<?php

mysqli_close($conn);
