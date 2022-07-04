<?php

require('../../../db/conn.php');

$id = $_POST['id'];

$sql = $conn->prepare("DELETE FROM comments WHERE id=?");
$sql->bind_param("i", $id);

if ($sql->execute()) {
   $sql->close();
   mysqli_close($conn);
}
