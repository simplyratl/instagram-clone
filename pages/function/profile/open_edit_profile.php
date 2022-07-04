<?php

require('../../../db/conn.php');

$id = $_POST['id'];

$username = $email = $password = $picture = $name = '';

$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   if ($row = $result->fetch_assoc()) {

      $username = $row['username'];
      $email = $row['email'];
      $name = $row['fullname'];
      $picture = $row['profile_picture'];
      $password = $row['password'];
?>
      <div class="edit-profile-container" id="profile-edit">
         <div class="edit-profile-wrapper">
            <div class="top-bar">
               <h1>Edit profile</h1>
               <i class="fa-solid fa-xmark close" id="close"></i>
            </div>

            <div class="row">
               <span class="label">
                  Image
               </span>
               <div class="image-container">
                  <img src="../uploads/avatars/<?php echo $picture; ?>" id="image-avatar">
               </div>

               <input type="file" name="image" id="image" accept="image/*" onchange="document.getElementById('image-avatar').src = window.URL.createObjectURL(this.files[0]);" />
            </div>

            <div class="row">
               <span class="label">
                  Username
               </span>
               <input type="text" name="username" autocomplete="off" value="<?php echo $username; ?>" id="username">
            </div>

            <div class="row">
               <span class="label">
                  Name and Surname
               </span>
               <input type="text" name="name" autocomplete="off" value="<?php echo $name; ?>" id="name">
            </div>

            <div class="row">
               <span class="label">
                  Email
               </span>
               <input type="email" name="email" autocomplete="off" value="<?php echo $email; ?>" id="email">
            </div>

            <div class="row">
               <span class="label">
                  Password
               </span>
               <input type="password" name="password" value="<?php echo $password; ?>" id="password">
            </div>

            <input type="hidden" id="id" value="<?php echo $id ?>" />
            <button class="btn-submit-edit" id="edit-post-btn">Submit</button>
         </div>
      </div>
<?php
   }
}
