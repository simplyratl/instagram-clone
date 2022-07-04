<?php
//FETCH POSTS

require('../../db/conn.php');

$fetchPosts = "SELECT * FROM posts ORDER BY id DESC;";

$resultPosts = $conn->query($fetchPosts);


while ($row = $resultPosts->fetch_assoc()) {
   $likeCount = 0;
   $likedCurrent = false;

   $fetchLikes = "SELECT COUNT(post_id) as counter FROM likes WHERE post_id=" . $row['id'];
   $resultFetchLikes = $conn->query($fetchLikes);

   $personalLikes = "SELECT * FROM likes WHERE user_id = " . $_SESSION['id'] . " AND post_id = " . $row['id'];
   $personalLikesResult = $conn->query($personalLikes);

   $fetchComments = "SELECT * FROM comments WHERE post_id=" . $row['id'];
   $fetchResult = $conn->query($fetchComments);

   $fetchPostUser = "SELECT * FROM users WHERE username = '" . $row['post_owner'] . "'";
   $resultPostUser = $conn->query($fetchPostUser);
   $currentUser = $resultPostUser->fetch_assoc();


   if ($resultFetchLikes->num_rows > 0) {
      $likeCount = $resultFetchLikes->fetch_assoc();
   }

   if ($personalLikesResult->num_rows > 0) {
      $likedCurrent = true;
   } else {
      $likedCurrent = false;
   }

?>
   <div class="post">
      <div class="top-bar">
         <div class="left">
            <a href="./profile.php?username=<?php echo $row['post_owner']; ?>">
               <img src="../uploads/avatars/<?php echo $currentUser["profile_picture"]; ?>" class="owner-image" />
            </a>

            <span class="user-name">
               <a href="./profile.php?username=<?php echo $row['post_owner']; ?>"><?php echo $row['post_owner']; ?></a>
            </span>
         </div>

         <?php if ($_SESSION['username'] == $row['post_owner'] || $_SESSION['id'] == 1 || $_SESSION['id'] == 50) : ?>
            <div class="edit-container" id="edit-container">
               <i class="fa-solid fa-ellipsis edit-btn" id="edit-btn" data-id="<?php echo $row['id'] ?>"></i>

               <ul class="post-actions" id="post-actions" data-post-settings="<?php echo $row['id'] ?>">
                  <li data-id="<?php echo $row['id'] ?>" id="edit-post">
                     <i class="fa-solid fa-pen-to-square"></i>
                     Post edit
                  </li>
                  <li data-id="<?php echo $row['id'] ?>" id="delete-post">
                     <i class=" fa-solid fa-trash-can"></i>
                     Post delete
                  </li>
               </ul>
            </div>
         <?php endif; ?>
      </div>

      <div class="post-image">
         <img src="../uploads/posts/<?php echo $row['image_url']; ?>" id="post-image-main" data-id="<?php echo $row['id']; ?>" />
         <i class="fa-solid fa-heart liked-big" id="liked-big" data-liked=<?php echo $row['id']; ?>></i>
      </div>

      <div class="bottom-bar">
         <div class="control-bar" id="control-bar-like">
            <i class="<?php echo ($likedCurrent ? " fa-solid fa-heart icon heart" : "fa-regular fa-heart icon") ?>" data-id="<?php echo $row['id']; ?>" id="likeBtn"></i>
            <i class="fa-regular fa-comment icon" id="comment-icon"></i>
         </div>

         <div class="like-counter" id="user-likes" data-id="<?php echo $row["id"]; ?>">
            <?php echo $likeCount['counter']; ?> Likes
         </div>

         <div class="comments-section">

            <span class="user-name">
               <a href="./profile.php?username=<?php echo $row['post_owner']; ?>"><?php echo $row['post_owner']; ?></a>
            </span>
            <span class="description-text"><?php echo $row['description']; ?></span>
            <span class="comments-tag">Comments</span>

            <div id="comment-section-display">
               <?php
               while ($comment = $fetchResult->fetch_assoc()) {
               ?>
                  <div class="comment <?php echo ($comment['user_id'] == $_SESSION['id'] || $_SESSION['id'] == 1 || $_SESSION['id'] == 50) ? 'current' : ''; ?>" id="comment-post" data-id="<?php echo $row['id'] ?>">
                     <div class="left">
                        <span class="user-name">
                           <a href="./profile.php?username=<?php echo $comment['username']; ?>"><?php echo $comment['username']; ?></a>
                        </span>
                        <span class="comment-text"><?php echo $comment['comment']; ?></span>
                     </div>

                     <?php if ($comment['user_id'] == $_SESSION['id'] || $_SESSION['id'] == 1 || $_SESSION['id'] == 50) : ?>
                        <i class="fa-solid fa-xmark remove" data-id="<?php echo $comment['id']; ?>" id="remove-comment"></i>
                     <?php endif; ?>
                  </div>

               <?php
                  //KRAJ KOMENTARA WHILE PETLJA
               }
               ?>

            </div>
            <div class="input-comment">
               <input type="text" class="comment-user" placeholder="Insert your comment here." id="comment-user<?php echo $row['id']; ?>" />
               <button type="button" id="post-comment" class="post-comment" data-id="<?php echo $row['id']; ?>">Post</button>
            </div>
            </>
         </div>
      </div>
   </div>
<?php
}
