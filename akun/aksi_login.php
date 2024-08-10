<?php
include ("../config.php");

// Mulai sesi
session_start();

// Ambil nilai username dan password dari formulir login
$username = $_POST['username'];
$password = $_POST['password'];

// Kueri SQL untuk memeriksa keberadaan username dalam tabel users
$sql = "SELECT user_id, username, password FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Periksa apakah ada baris yang cocok
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Verifikasi password
    if ($user['password'] == $password) {
        // Izinkan akses
        echo "<script>alert('Login berhasil!');</script>";

        // Simpan username dan user_id ke dalam sesi
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['user_id'];

        // Redirect ke halaman setelah login
        header("Location: ../index.php");
    } else {
        // Password salah
        echo "<script>alert('Username atau password salah.');</script>";
        header("Location: login.php?error=1");
    }
} else {
    // Username tidak ditemukan
    echo "<script>alert('Username atau password salah.');</script>";
    header("Location: login.php?error=1");
}
?>
