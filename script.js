function selectGroup(group) {
  var groupName = group.innerText;
  document.getElementById("groupName").innerText = groupName;
  // Panggil fungsi untuk memuat anggota grup saat grup dipilih
  loadGroupMembers(groupName);

  var addMemberButton = document.getElementById("addMemberButton");
    addMemberButton.style.display = "block";
}

function sendMessage() {
  var message = document.getElementById("messageInput").value;
  var selectedGroup = document.getElementById("groupName").innerText;

  // Kirim pesan ke server menggunakan AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "send_message.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Respon dari server
      var response = xhr.responseText;
      // Tampilkan respon atau lakukan tindakan lain jika diperlukan
      console.log(response);
      // Setelah pesan dikirim, kosongkan nilai input
      document.getElementById("messageInput").value = "";
      // Muat kembali pesan untuk grup yang dipilih
      loadChatMessages(document.getElementById("groupName"));
    }
  };
  xhr.send("group=" + selectedGroup + "&message=" + message);
}

function loadChatMessages(selectedItem) {
  var selectedGroup = selectedItem.innerText;

  // Kirim permintaan AJAX ke skrip PHP untuk mengambil pesan dari grup yang dipilih
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "get_messages.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Respon dari server (data pesan dalam format JSON)
      var response = xhr.responseText;
      var messages = JSON.parse(response);

      // Membalikkan urutan pesan
      messages.reverse();

      // Menampilkan pesan-pesan dalam area obrolan
      var chatMessages = document.getElementById("chatMessages");
      chatMessages.innerHTML = ""; // Kosongkan area obrolan sebelum menampilkan pesan baru
      messages.forEach(function (msg) {
        var messageDiv = document.createElement("div");
        // Tentukan kelas pesan berdasarkan peran pengguna
        if (msg.sender === "Me") {
          messageDiv.className = "sent-message";
        } else {
          messageDiv.className = "received-message";
        }
        messageDiv.innerHTML =
          "<strong>" +
          msg.sender +
          "</strong>: " +
          msg.message +
          " <span>(" +
          msg.timestamp +
          ")</span>";
        chatMessages.appendChild(messageDiv);
      });

      // Setel scrollTop ke tinggi elemen untuk menggulir ke bawah
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  };
  xhr.send("group=" + selectedGroup);
}


// Memuat pesan secara otomatis setiap beberapa detik (misalnya, setiap 5 detik)
setInterval(function () {
  loadChatMessages(document.getElementById("groupName"));
}, 1000); // 2000 milliseconds = 2 detik

// Fungsi untuk memuat anggota grup saat grup dipilih
function loadGroupMembers(groupName) {
  // Kirim permintaan AJAX ke skrip PHP untuk mendapatkan daftar anggota grup beserta peran (admin/member)
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "get_group_members.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Respon dari server (data anggota grup dalam format JSON)
      var response = xhr.responseText;
      var members = JSON.parse(response);

      // Tampilkan anggota grup dalam daftar
      var groupMembersList = document.getElementById("groupMembersList");
      groupMembersList.innerHTML = ""; // Kosongkan daftar sebelum menambahkan anggota baru
      members.forEach(function (member) {
        var memberItem = document.createElement("li");
        // Tambahkan nama anggota
        memberItem.textContent = member.username;
        // Tambahkan keterangan peran (admin/member)
        var roleSpan = document.createElement("span");
        roleSpan.textContent = " (" + member.role + ")";
        roleSpan.style.marginLeft = "5px"; // Beri jarak dari nama anggota
        memberItem.appendChild(roleSpan);
        groupMembersList.appendChild(memberItem);
      });
    }
  };
  xhr.send("group=" + groupName);
}

function addNewGroup() {
  // Redirect ke halaman pembuatan grup
  window.location.href = "create_grup/create_group.html"; // Ganti dengan URL halaman pembuatan grup yang sebenarnya
}
// Ambil pesan konfirmasi dari URL jika ada
const urlParams = new URLSearchParams(window.location.search);
const success = urlParams.get("success");

// Cek apakah parameter success=true ada dalam URL
if (success === "true") {
  // Tampilkan pesan konfirmasi
  const successMessage = document.getElementById("successMessage");
  successMessage.style.display = "block";

  // Sembunyikan pesan konfirmasi setelah 3 detik
  setTimeout(function () {
    successMessage.style.display = "none";
  }, 3000);
}

// untuk menampilkan modal tambah teman
 // Dapatkan modal
 var modal = document.getElementById('addFriendModal');

 // Dapatkan tombol yang membuka modal
 var btn = document.getElementById('showAddFriendFormBtn');

 // Ketika pengguna mengklik tombol, buka modal
 btn.onclick = function() {
     modal.style.display = "block";
 }

 // Ketika pengguna mengklik di luar modal, tutup modal
 window.onclick = function(event) {
     if (event.target == modal) {
         modal.style.display = "none";
     }
 }
// untuk mencari user
function searchUser() {
  var input = document.getElementById('searchInput').value;
  var searchResults = document.getElementById('searchResults');
  if (input.length > 0) {
      // Lakukan permintaan ke server untuk mencari pengguna
      fetch('search_user.php?q=' + input)
      .then(response => response.json())
      .then(data => {
          searchResults.innerHTML = '';
          data.forEach(user => {
              var userDiv = document.createElement('div');
              userDiv.textContent = user.username;
              userDiv.onclick = function() {
                  document.getElementById('searchInput').value = user.username;
                  searchResults.style.display = 'none';
              };
              searchResults.appendChild(userDiv);
          });
          searchResults.style.display = 'block';
      });
  } else {
      searchResults.style.display = 'none';
  }
}
