<?php

require('../../../db/conn.php');

$id = $_POST['id'];
$user = $_SESSION['username'];

$sqlDeleteComments = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
$sqlDeleteComments->bind_param("i", $id);
$sqlDeleteComments->execute();
$sqlDeleteComments->close();


$sqlDeleteLikes = $conn->prepare("DELETE FROM likes WHERE post_id = ?");
$sqlDeleteLikes->bind_param("i", $id);
$sqlDeleteLikes->execute();
$sqlDeleteLikes->close();


if ($_SESSION['id'] == 1) {
   $sql = $conn->prepare("DELETE FROM posts WHERE id=?");
   $sql->bind_param("i", $id);
} else {
   $sql = $conn->prepare("DELETE FROM posts WHERE id=? AND post_owner = ?");
   $sql->bind_param("is", $id, $user);
}

if ($sql->execute() == true) {
   echo 'deleted';
} else {
   echo 'not deleted';
}

mysqli_close($conn);
$sql->close();
