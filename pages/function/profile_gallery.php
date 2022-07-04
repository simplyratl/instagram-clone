<?php

require('../../db/conn.php');

$postId = $_POST['post_id'];
$sql = "INSERT INTO comments(post_id, user_id, comment, username) VALUES('$postId', '$userId', '$postComment', '$username')";

if ($conn->query($sql)) {
   mysqli_close($conn);
   echo true;
} else {
   echo false;
}
