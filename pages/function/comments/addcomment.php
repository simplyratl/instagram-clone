<?php

require('../../../db/conn.php');

$postId = $_POST['post_id'];
$postComment = $_POST['comment'];
$userId = $_SESSION['id'];
$username = $_SESSION['username'];

$sql = $conn->prepare("INSERT INTO comments(post_id, user_id, comment, username) VALUES(?,?,?,?)");
$sql->bind_param("iiss", $postId, $userId, $postComment, $username);


if ($sql->execute()) {
?>
   <div class="comment <?php ($userId == $_SESSION['id'] || $_SESSION['username'] == 'admin' ? 'current' : '') ?>" id="comment-post" data-id="<?php echo $row['id'] ?>">
      <div class="left">
         <span class="user-name">
            <a href="./profile.php?username=<?php echo $username; ?>"><?php echo $username; ?></a>
         </span>
         <span class="comment-text"><?php echo $postComment; ?></span>
      </div>

      <i class="fa-solid fa-xmark remove" data-id="<?php echo $postId; ?>" id="remove-comment"></i>;
   </div>

<?php

   $sql->close();
   mysqli_close($conn);
} else {
}
