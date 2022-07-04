<?php

require('../../../db/conn.php');

$username = $_SESSION['username'];
$picture = $_POST['image'];
$description = $_POST['description'];

if (strlen($picture) > 0) {
   $sqlAddPost = $conn->prepare("INSERT INTO posts(post_owner, image_url, description) VALUES(?,?,?)");
   $sqlAddPost->bind_param("sss", $username, $picture, $description);
   $sqlAddPost->execute();

   $sqlAddPost->close();
}
