<?php

require('../../../db/conn.php');

$postID = $_POST['id'];

$sql = "SELECT * FROM posts WHERE id='$postID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   if ($row = $result->fetch_assoc()) {
?>
      <div class="post-edit-container" id="post-edit" data-id="<?php echo $postID; ?>">
         <div class="post-edit-wrapper">
            <div class="top-bar">
               <span>Edit post description</span>
               <i class="fa-solid fa-xmark close" id="close-edit"></i>
            </div>
            <textarea type="text" placeholder="Change post description." id="description-edit"><?php echo $row['description']; ?></textarea>
            <button type="button" class="edit-post-btn" id="edit-post-btn">Update</button>
         </div>
      </div>
<?php
   }
}
