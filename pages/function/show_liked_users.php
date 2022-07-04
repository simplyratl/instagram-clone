<?php
require('../../db/conn.php');

$postID = $_POST['id'];

$sql = "SELECT user_id FROM likes WHERE post_id = $postID";
$result = $conn->query($sql);

?>

<div class="show-liked-users">
   <div class="show-liked-users-wrapper">
      <div class="top-bar">
         <h3>Likes</h3>
         <i class="fa-solid fa-xmark remove" id="close-user-likes"></i>
      </div>
      <ul class="user-list">


         <?php

         if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
               $sqlUsers = "SELECT * FROM users WHERE id=" . $row['user_id'];
               $resultUsers = $conn->query($sqlUsers);
               $rowUsers = $resultUsers->fetch_assoc();
         ?>
               <li>
                  <a href="#">
                     <img src="../uploads/avatars/<?php echo $rowUsers['profile_picture'] ?>" />
                  </a>

                  <a href="#">
                     <h3><?php echo $rowUsers['username'] ?></h3>
                  </a>
               </li>
            <?php
            }
         } else {
            ?>
            <li>
               <h3>No user liked this post.</h3>
            </li>

         <?php
         }

         ?>

      </ul>
   </div>
</div>

<?php

mysqli_close($conn);
