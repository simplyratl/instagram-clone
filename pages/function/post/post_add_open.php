<?php

require('../../../db/conn.php');

//FETCH PODATAKA ZA PRIKAZ
$username = $_SESSION['username'];
$profileImage = $pictureUploadSuccess = '';

$fetchUser = "SELECT * FROM users WHERE username = '$username';";

$resultUser = $conn->query($fetchUser);

while ($row = $resultUser->fetch_assoc()) {
   $profileImage = $row['profile_picture'];
}

?>
<div class="add-post-modal-container active" id="add-post-modal">
   <div class="add-post-wrapper">
      <div class=" top-bar">
         <i class="fa-solid fa-xmark close" onclick="closeAddPost()"></i>
         <h4>Make post</h4>
         <button type="button" name="submit" class="share-btn" id="share">Share</button>
      </div>

      <div class="main-section">
         <div class="upload-picture" id="upload-picture">
            <div class="helper" id="post-image-help">
               <i class="fa-solid fa-upload icon"></i>
               <h6 style="font-size: 16px;">Click to upload picture.</h6>
            </div>

            <img class='added-image hidden' id="image" src="" />

            <input type="file" name="image" id="post-image" accept="image/*" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0]);
                  document.getElementById('image').classList.remove('hidden');
                  document.getElementById('post-image-help').remove();
                  " />

         </div>

         <div class="right-side">
            <div class="profile">
               <img src="../uploads/avatars/<?php echo $profileImage; ?>" class="avatar-image" />
               <span class="title"><?php echo $username; ?></span>
            </div>

            <textarea name="description" id="description" cols="30" rows="10" placeholder="Type in description"></textarea>
         </div>
      </div>
   </div>
</div>
<?php
