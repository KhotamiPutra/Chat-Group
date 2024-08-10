<?php
include("config.php");

// Mulai sesi
session_start();

// Periksa apakah ada user yang sudah masuk
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada, mungkin perlu melakukan redirect atau menampilkan pesan kesalahan
    exit("Akses ditolak. Harap login terlebih dahulu.");
}

// Ambil ID pengguna yang masuk dari sesi
$current_user_id = $_SESSION['user_id'];

// Query untuk mendapatkan pengguna lain
$sql = "SELECT user_id, username FROM users WHERE user_id != $current_user_id";
$result = mysqli_query($conn, $sql);

$users = array();

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = array(
                'user_id' => $row['user_id'],
                'username' => $row['username']
            );
        }
    } else {
        echo "Tidak ada pengguna lain yang ditemukan.";
    }

    // Mengembalikan hasil dalam format JSON
    echo json_encode($users);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_close($conn);
?>
