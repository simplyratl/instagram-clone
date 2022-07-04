<?php

require('../../../db/conn.php');

$id = $_POST['id'];
$username = $_POST['username'];
$name = $_POST['name'];
$password = $_POST['password'];
$email = $_POST['email'];
$picture = $_POST['image'];
$originalUsername = $_POST['originalUsername'];

if (strlen($picture) > 0) {
   $sql = $conn->prepare("UPDATE users SET email=?, fullname=?, username=?, password=?, profile_picture=? WHERE id=?");
   $sql->bind_param("sssssi", $email, $name, $username, $password, $picture, $id);
} else {
   $sql = $conn->prepare("UPDATE users SET email=?, fullname=?, username=?, password=? WHERE id=?");
   $sql->bind_param("ssssi", $email, $name, $username, $password, $id);
   $sql->execute();
}

$sqlUpdatePosts = $conn->prepare("UPDATE posts SET post_owner = ? WHERE post_owner=?");
$sqlUpdatePosts->bind_param("ss", $username, $originalUsername);

$sqlUpdateComments = $conn->prepare("UPDATE comments SET username = ? WHERE username = ?");
$sqlUpdateComments->bind_param("ss", $username, $originalUsername);



if ($sqlUpdatePosts->execute() && $sql->execute() && $sqlUpdateComments->execute()) {
   $_SESSION['username'] = $username;
   $_SESSION['id'] = $id;
}

$sqlUpdatePosts->close();
$sqlUpdateComments->close();
$sql->close();
mysqli_close($conn);
