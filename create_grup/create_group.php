<?php
include("../config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);

        // Masukkan detail grup baru ke dalam tabel groups
        $sql_insert_group = "INSERT INTO groups (group_name) VALUES ('$group_name')";
        if (mysqli_query($conn, $sql_insert_group)) {
            // Dapatkan ID grup yang baru saja dibuat
            $group_id = mysqli_insert_id($conn);

            // Dapatkan ID pengguna yang membuat grup
            $sql_user_id = "SELECT user_id FROM users WHERE username = '$username'";
            $result_user_id = mysqli_query($conn, $sql_user_id);
            $row_user_id = mysqli_fetch_assoc($result_user_id);
            $admin_user_id = $row_user_id['user_id'];

            // Tetapkan pengguna yang membuat grup sebagai admin
            $sql_insert_admin = "INSERT INTO group_members (group_id, user_id, role) VALUES ($group_id, $admin_user_id, 'admin')";
            mysqli_query($conn, $sql_insert_admin);

            echo "Grup berhasil dibuat.";
        } else {
            echo "Error: " . $sql_insert_group . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Silakan masuk untuk membuat grup.";
    }
    header("Location: ../index.php?success=true");
exit();
}
?>
