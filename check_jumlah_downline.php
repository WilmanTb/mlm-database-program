<?php

include 'database.php';
$uplineId = $_POST['uplineId'];

// Mengecek jumlah entri dengan uplineId yang sama
$query = "SELECT COUNT(member_id)  as count FROM member WHERE member_uplineId = '$uplineId'";
$result = mysqli_query($con, $query);
$row = $result->fetch_assoc();

if ($row['count'] >= 2) {
    echo "GAGAL";
} else {
    echo "BERHASIL";
}
