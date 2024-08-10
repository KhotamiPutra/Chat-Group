<?php
// Mulai sesi
session_start();

// Koneksi ke database
$host = "127.0.0.1"; // atau localhost
$username = "root"; // username untuk database
$password = ""; // password untuk database
$dbname = "aul"; // nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // Password tanpa hash

    // SQL untuk memasukkan data
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    // Eksekusi query dan periksa apakah berhasil
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registrasi berhasil!');</script>";
        // Redirect ke halaman login atau lainnya
        echo "<script>window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>

