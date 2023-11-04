$(document).ready(function () {
  // Pencarian dengan AJAX
  $("#search_button").on("click", function () {
    var searchKeyword = $("#search_keyword").val();
    if (searchKeyword == "") {
      alert("Form mohon isi kolom pencarian");
    } else {
      $.ajax({
        url: "pencarian.php",
        method: "POST",
        data: {
          search_keyword: searchKeyword,
        },
        success: function (data) {
          $("#search_results").html(data);
          window.scrollTo(0, document.body.scrollHeight);
        },
      });
    }
  });

  // Menambahkan member dengan AJAX
  $("#add_member_button").on("click", function () {
    var mnum = $("#member_number").val();
    var name = $("#member_nama").val();
    var address = $("#member_alamat").val();
    var phone_number = $("#member_notelp").val();
    var uplineId = $("#uplineId").val();
    var memberList = document.getElementById("member");
    var selectList = document.getElementById("search_results");

    if (
      mnum == "" ||
      name == "" ||
      address == "" ||
      phone_number == "" ||
      uplineId == ""
    ) {
      alert("Form data member tidak boleh kosong");
    } else {
      $.ajax({
        url: "check_jumlah_downline.php",
        method: "POST",
        data: {
          uplineId: uplineId,
        },
        success: function (response) {
          if (response == "GAGAL") {
            alert(
              "ERROR: Upline sudah memiliki 2 downline\nMohon pilih salah satu upline dari tabel dibawah ini "
            );
            memberList.style.display = "block";
            selectList.style.display = "none";
            window.scrollTo(0, document.body.scrollHeight);
          } else {
            // Jika tidak terlalu banyak entri dengan uplineId yang sama, kirim data
            $.ajax({
              url: "add_member.php",
              method: "POST",
              data: {
                mnum: mnum,
                name: name,
                address: address,
                phone_number: phone_number,
                uplineId: uplineId,
              },
              success: function (response) {
                alert("Data Berhasil Disimpan");
                $("#member_number").val("");
                $("#member_nama").val("");
                $("#member_alamat").val("");
                $("#member_notelp").val("");
                $("#uplineId")[0].selectedIndex = 0;
                location.reload();
              },
            });
          }
        },
      });
    }
  });
});
