<?php
include "./include/session.php";
include "./include/connection.php";
$uid = $_SESSION['id'];
$Sql = "SELECT `status` FROM `users` WHERE `id` = '$uid'";

$result = mysqli_query($conn, $Sql);
if($row = mysqli_fetch_array($result)){
$_SESSION['status'] = $row['status'];
header('location:index.php');
}
?>