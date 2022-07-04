<?php

require('../../../db/conn.php');

$fetchComments = "SELECT * FROM comments WHERE post_id=" . $row['id'];
$fetchResult = $conn->query($fetchComments);

while ($comment = $fetchResult->fetch_assoc()) {

?>
   <div class="comment ' <?php ($comment['user_id'] == $_SESSION['id'] || $_SESSION['username'] == 'admin' ? 'current' : '') ?>">
      <div class="left">
         <span class="user-name">
            <a href="./profile.php?username=<?php echo $comment['username'] ?>"> <?php echo $comment['username'] ?> </a>
         </span>
         <span class="comment-text"><?php echo $comment['comment'] ?></span>
      </div>

      <i class="fa-solid fa-xmark remove" data-id="<?php echo $comment['id']; ?>" id="remove-comment"></i>
   </div>

<?php
}
