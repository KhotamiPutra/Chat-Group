<?php
include("config.php");
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['message'] = "Anda harus masuk untuk menambahkan teman.";
    header("Location: index.php");
    exit;
}

$my_username = $_SESSION['username'];
$friend_username = $_POST['friend_username'];

// Cek apakah username teman ada
$sql_check = "SELECT user_id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt, "s", $friend_username);
mysqli_stmt_execute($stmt);
$result_check = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result_check) == 0) {
    $_SESSION['message'] = "Username tidak ditemukan.";
    header("Location: index.php");
    exit;
}

$row = mysqli_fetch_assoc($result_check);
$friend_id = $row['user_id'];
mysqli_stmt_close($stmt); // Tutup statement setelah digunakan

// Cek apakah sudah berteman
$sql_check_friend = "SELECT * FROM friends WHERE (user1_id = (SELECT user_id FROM users WHERE username = ?) AND user2_id = ?) OR (user1_id = ? AND user2_id = (SELECT user_id FROM users WHERE username = ?))";
$stmt = mysqli_prepare($conn, $sql_check_friend);
mysqli_stmt_bind_param($stmt, "ssss", $my_username, $friend_id, $friend_id, $my_username);
mysqli_stmt_execute($stmt);
$result_check_friend = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result_check_friend) > 0) {
    $_SESSION['message'] = "Anda sudah berteman dengan pengguna ini.";
    header("Location: index.php");
    exit;
}

// Tambahkan teman
$sql_add = "INSERT INTO friends (user1_id, user2_id) VALUES ((SELECT user_id FROM users WHERE username = ?), ?)";
$stmt = mysqli_prepare($conn, $sql_add);
mysqli_stmt_bind_param($stmt, "ss", $my_username, $friend_id);
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['message'] = "Teman berhasil ditambahkan.";
} else {
    $_SESSION['message'] = "Gagal menambahkan teman.";
}
header("Location: index.php");
exit;
?>


