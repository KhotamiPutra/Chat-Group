<?php
include("config.php");
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Query untuk mengambil ID pengguna berdasarkan nama pengguna
    $sql = "SELECT user_id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Query untuk mengambil daftar grup yang dimiliki oleh pengguna
        $sql_groups = "SELECT groups.group_name FROM group_members JOIN groups ON group_members.group_id = groups.group_id WHERE group_members.user_id = $user_id";
        $result_groups = mysqli_query($conn, $sql_groups);

        // Query untuk mengambil daftar teman dari pengguna
        $sql_friends = "SELECT users.username FROM users
                        JOIN friends ON users.user_id = friends.user1_id OR users.user_id = friends.user2_id
                        WHERE (friends.user1_id = ? OR friends.user2_id = ?) AND users.user_id != ?";
        $stmt = mysqli_prepare($conn, $sql_friends);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $user_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result_friends = mysqli_stmt_get_result($stmt);
    } else {
        echo "User not found";
    }
} else {
    $username = "Guest"; // Atau sesuaikan dengan nilai default yang sesuai
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grup Chatting</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>

<body>
    <div id="notification" class="notification"></div>

    <nav>
        <h1>Group Chatting</h1>
        <div class="profile">
            <img src="asset/user.png" alt="" srcset="">
            <p>Welcome, <?php echo $username; ?></p>
        </div>

    </nav>
    <div id="successMessage" style="display: none;" class="notification">
        Grup telah berhasil dibuat!
    </div>

    <div class="container">
        <div class="connection">
            <div class="groups">
                <h2>Message</h2>
                <ul id="groupList">
                    <?php
        if (mysqli_num_rows($result_groups) > 0) {
            // Output data dari setiap baris
            while ($row = mysqli_fetch_assoc($result_groups)) {
                echo "<li onclick=\"selectGroup(this)\">" . $row["group_name"] . "</li>";
            }
        } else {
            echo "Belum memiliki grup";
        }
        ?>
                </ul>
                <button onclick="addNewGroup()">Tambah Grup</button>
            </div>

            <div class="friend">
                <h2>Daftar Teman</h2>
                <!-- Tombol untuk membuka modal -->
                <button id="showAddFriendFormBtn">Tambah Teman</button>

                <!-- Modal -->
                <div id="addFriendModal" class="modal">
                    <div class="modal-content">
                        <form action="add_friend.php" method="post">
                            <input type="text" id="searchInput" name="friend_username" placeholder="Cari username..." oninput="searchUser()">
                            <div id="searchResults" class="search-results"></div>
                            <button type="submit">Tambah Teman</button>
                        </form>
                    </div>
                </div>

                <ul id="friendList" class="friend-list">
                    <?php
        if (mysqli_num_rows($result_friends) > 0) {
            // Output data dari setiap baris
            while ($row = mysqli_fetch_assoc($result_friends)) {
                echo "<li class=\"friend-item\" onclick=\"selectFriend(this)\">" . $row["username"] . "</li>";
            }
        } else {
            echo "Belum memiliki teman";
        }
        ?>
                </ul>
            </div>

        </div>

        <div class="chat">
            <div id="chatHeader">
                <h2 id="groupName">Pilih Grup</h2>
                <p id="groupMembers"></p>
            </div>

            <div id="chatMessages" class="message-container">
                
            </div>

            <div id="messageInputContainer">
                <input type="text" id="messageInput" placeholder="Ketik pesan...">
                <button id="sendMessageBtn" onclick="sendMessage()">Kirim</button>
            </div>

        </div>
        <div id="groupMembersContainer">
            <h3>Anggota Grup</h3>
            <ul id="groupMembersList"></ul>
            <a href="addMember/AddMember.php"><button>Tambah Anggota</button></a>
            
        </div>
    </div>

    <script src="script.js"></script>
    <?php
$friend_list = array();

if (mysqli_num_rows($result_friends) > 0) {
    while ($row = mysqli_fetch_assoc($result_friends)) {
        $friend_list[] = $row["username"];
    }
}
?>

<script src="script.js"></script>
    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['message'])) { ?>
                var notification = document.getElementById('notification');
                notification.textContent = '<?php echo $_SESSION['message']; ?>';
                notification.style.display = 'block';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 3000);
                <?php unset($_SESSION['message']); ?>
            <?php } ?>
        };
    </script>
</body>

</html>
