<?php
require('../db/conn.php');

if (!isset($_SESSION['username'])) {
   header("Location: login.php");
}

//FETCH PODATAKA ZA PRIKAZ
$username = $_SESSION['username'];
$profileImage = $pictureUploadSuccess = '';

$fetchUser = "SELECT * FROM users WHERE username = '$username';";

$resultUser = $conn->query($fetchUser);

while ($row = $resultUser->fetch_assoc()) {
   $profileImage = $row['profile_picture'];
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
   <link rel="stylesheet" href="../style/dist/show-liked-users.min.css" />
   <link rel="stylesheet" href="../style/dist/spinner.css" />
   <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Instagram-Icon.png/769px-Instagram-Icon.png" type="image/png">
   <title>Instagram</title>
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
               <a href="index.php" style="color: #000;"><i class="fa-solid fa-house element icon"></i></a>
               <i class="fa-solid fa-plus icon element" style="font-size: 1.8rem;" id="add-post" onclick="openAddPost()"></i>

               <div class="avatar-image" onclick="openUserSettings()" id="user-avatar">
                  <img src="../uploads/avatars/<?php echo $profileImage; ?>" class="user-avatar element" />

                  <div class="sub-menu" id="sub-menu">
                     <ul>
                        <a href="profile.php?username=<?php echo $username; ?>">
                           <li>
                              <i class="fa-regular fa-user"></i>
                              Profile
                           </li>
                        </a>
                        <a href="settings.php?username=<?php echo $username ?>">
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

      <div class="main-wrapper">
         <div class="main-section">
            <div class="posts-container" id="posts-container">

            </div>

         </div>
      </div>
   </div>


   <div id="user-likes-container"></div>


   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/main.js"></script>
   <script src="../js/search.js"></script>
   <script src="../js/liked_users.js"></script>
   <script src="../js/edit_post.js"></script>
   <script>
      if (window.history.replaceState) {
         window.history.replaceState(null, null, window.location.href);
      }
   </script>
</body>

</html>