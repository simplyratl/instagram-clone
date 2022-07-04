<?php

require('../../db/conn.php');

$postId = $_POST['post_id'];
$userId = $_SESSION['id'];

$sqlCheck = "SELECT * FROM likes WHERE post_id='$postId' AND user_id='$userId'";
$checkResult = $conn->query($sqlCheck);

if ($checkResult->num_rows > 0) {
   $removeLike = $conn->prepare("DELETE FROM likes WHERE post_id=? AND user_id=?");
   $removeLike->bind_param("ii", $postId, $userId);
   $removeLike->execute();
   $removeLike->close();

   mysqli_close($conn);
} else {
   $sql = $conn->prepare("INSERT INTO likes(post_id, user_id) VALUES(?, ?)");
   $sql->bind_param('is', $postId, $userId);

   if ($sql->execute()) {
      mysqli_close($conn);
   }

   $sql->close();
}
