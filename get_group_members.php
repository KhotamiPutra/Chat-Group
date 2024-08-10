<?php
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah pengguna sudah masuk atau belum
    if (isset($_SESSION['username'])) {
        $selectedGroup = $_POST['group'];

        // Query untuk mengambil daftar anggota grup dari database
        $sql = "SELECT users.username, group_members.role FROM group_members JOIN users ON group_members.user_id = users.user_id WHERE group_members.group_id = (SELECT group_id FROM groups WHERE group_name = '$selectedGroup')";
        $result = mysqli_query($conn, $sql);

        $members = array();

        if (mysqli_num_rows($result) > 0) {
            // Mengisi array $members dengan data anggota grup
            while ($row = mysqli_fetch_assoc($result)) {
                // Menambahkan informasi peran ke dalam array
                $members[] = array(
                    'username' => $row['username'],
                    'role' => $row['role']
                );
            }
        }

        // Mengembalikan data anggota grup dalam format JSON
        echo json_encode($members);
    } else {
        echo "Silakan masuk untuk melihat anggota grup.";
    }
}
?>
