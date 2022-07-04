<?php

require('../../db/conn.php');

sleep(0.5);

$search = $_POST['search'];
$sql = "SELECT * FROM users WHERE username LIKE '$search%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

   while ($row = $result->fetch_assoc()) {
?>

      <li class="suggestion">
         <a href="../pages/profile.php?username=<?php echo $row['username'] ?>">
            <img src="../uploads/avatars/<?php echo $row['profile_picture']; ?>" />
            <?php echo $row['username']; ?>
         </a>
      </li>

   <?php
   }
} else {
   ?>

   <li class="suggestion">
      Rezultat nije pronadjen
   </li>

<?php
}


mysqli_close($conn);
