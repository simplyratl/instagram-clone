<?php

require('../../../db/conn.php');

$postID = $_POST['id'];
$description = $_POST['description'];

$sql = $conn->prepare("UPDATE posts SET description=? WHERE id=?");
$sql->bind_param("si", $description, $postID);
$sql->execute();

$sql->close();
mysqli_close($conn);
