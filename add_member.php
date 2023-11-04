
<?php

include "database.php";

$mnum = $_POST["mnum"];
$name = $_POST["name"];
$address = $_POST["address"];
$phone_number = $_POST["phone_number"];
$uplineId = $_POST["uplineId"];

$insert_query = "INSERT INTO member (member_num,member_nama, member_alamat, member_notelp, member_uplineId) VALUES ('$mnum','$name', '$address', '$phone_number', '$uplineId')";
mysqli_query($con, $insert_query);
header("Location: index.php");

?>