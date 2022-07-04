<?php

$conn = new mysqli('localhost', 'root', '', 'instagram');

if ($conn->connect_error) {
   echo $conn->connect_error;
} else {
   session_start();
}
