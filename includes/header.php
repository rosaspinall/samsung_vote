<?php
$conn = mysqli_connect("localhost","samsung_vote","m6MG6jyzqdXACr4S","samsung_vote");

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

?>