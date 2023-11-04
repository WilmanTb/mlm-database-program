<?php

include "database.php";

$search_keyword = $_POST["search_keyword"];
$query = "SELECT 
m.*,
(select member_nama from member where member_id= m.member_uplineId) as upline,
GROUP_CONCAT(DISTINCT md.member_nama SEPARATOR ', ') as downline
FROM member m
LEFT JOIN member md ON m.member_id = md.member_uplineId
WHERE m.member_nama LIKE '%$search_keyword%' OR m.member_notelp LIKE '%$search_keyword%' OR m.member_num LIKE '%$search_keyword%'
GROUP BY m.member_id;";
$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Nomor Telepon</th><th>Upline</th><th>Downline</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["member_id"] . "</td>";
        echo "<td>" . $row["member_nama"] . "</td>";
        echo "<td>" . $row["member_alamat"] . "</td>";
        echo "<td>" . $row["member_notelp"] . "</td>";
        echo "<td>" . $row["upline"] . "</td>";
        echo "<td>" . $row["downline"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Tidak ada hasil yang ditemukan.";
}
