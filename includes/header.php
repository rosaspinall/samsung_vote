<?php
$conn = mysqli_connect("aadkt207k28z92.cwfwsgl1puow.eu-west-2.rds.amazonaws.com:3306","dbuser","PASSWORD","samsung_vote");

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

?>

<!DOCTYPE html>
<html>


<head>
    <title>Samsung Vote</title>
    <link rel="stylesheet" href="styles-local.css">
	
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	
	


</head>
	
	
<body class="backstage2">

<div id="page">