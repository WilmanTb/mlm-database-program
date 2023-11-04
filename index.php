<!DOCTYPE html>
<html>

<head>
  <title>MLM Database</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h4 align="center"><b>MLM Database</b></h4>
  <hr>
  <br>
  <h3><b>Add Member</b></h3>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="col-md-2 mb-2"> <!-- Adjust the column width and margin as needed -->
          <input type="text" id="member_number" placeholder="ID Member" class="input-text" required />
        </div>
        <div class="col-md-2 mb-2">
          <input type="text" id="member_nama" placeholder="Nama" class="input-text" required />
        </div>
        <div class="col-md-2 mb-2">
          <input type="text" id="member_alamat" placeholder="Alamat" class="input-text" required>
        </div>
        <div class="col-md-2 mb-2">
          <input type="text" id="member_notelp" placeholder="No Telepon" class="input-text" required />
        </div>
        <div class="col-md-6 mb-2">
          <select name="selectUpline" id="uplineId" class="input-select" required />
          <option value="">-- Select Upline --</option>
          <?php
          include 'database.php';
          $upline_query = "SELECT * FROM member";
          $result = mysqli_query($con, $upline_query);

          // Dropdown member
          if ($result) {
            while ($row1 = $result->fetch_assoc()) {
              echo "<option value=" . $row1['member_id'] . ">" . $row1['member_nama'] . "</option>";
            } // Close the result set
          }
          ?>
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <button id="add_member_button" class="add-member-button">Add Member</button>
        </div>

      </div>
    </div>
  </section>
  <hr>
  <br>
  <input type="text" id="search_keyword" placeholder="Search by ID, Name, or Phone Number">
  <button id="search_button" class="btn btn-primary">Search</button>

  <h3 align="center"><b>Daftar Member</b></h3>

  <!-- Tabel Seluruh Member -->
  <div id="search_results" class="search-result-table" style="display:block;">
    <?php
    include "database.php";

    $query = "SELECT
                m.*,
                (select member_nama from member where member_id= m.member_uplineId) as upline,
                GROUP_CONCAT(DISTINCT md.member_nama SEPARATOR ', ') as downline
                FROM member m
                LEFT JOIN member md ON m.member_id = md.member_uplineId
                GROUP BY m.member_id;";
    $result = mysqli_query($con, $query);

    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Nomor Telepon</th><th>Upline</th><th>Downline</th></tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["member_num"] . "</td>";
        echo "<td>" . $row["member_nama"] . "</td>";
        echo "<td>" . $row["member_alamat"] . "</td>";
        echo "<td>" . $row["member_notelp"] . "</td>";
        echo "<td>" . $row["upline"] . "</td>";
        echo "<td>" . $row["downline"] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    }
    ?>
  </div>
  <!--END Tabel Seluruh Member -->

  <!-- Tabel Member yang memiliki downline lebih kecil dari 2 -->
  <div id="member" class="search-result-table" style="display: none;">
    <?php
    include "database.php";

    $query = "SELECT
                m.*,
                (select member_nama from member where member_id= m.member_uplineId) as upline,
                GROUP_CONCAT(DISTINCT md.member_nama SEPARATOR ', ') as downline
                FROM member m
                LEFT JOIN member md ON m.member_id = md.member_uplineId
                WHERE
                (SELECT COUNT(member_id) as total from member where member_uplineId=m.member_id) < 2
                GROUP BY m.member_id;";
    $result = mysqli_query($con, $query);

    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Nomor Telepon</th><th>Upline</th><th>Downline</th></tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["member_num"] . "</td>";
        echo "<td>" . $row["member_nama"] . "</td>";
        echo "<td>" . $row["member_alamat"] . "</td>";
        echo "<td>" . $row["member_notelp"] . "</td>";
        echo "<td>" . $row["upline"] . "</td>";
        echo "<td>" . $row["downline"] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    }
    ?>
  </div>
  <!-- Tabel Member yang memiliki downline lebih kecil dari 2 -->

  <!-- Javascript fungsi tombol -->
  <script src="script.js"></script>

</body>

</html>