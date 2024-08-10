<?php
// Sertakan file konfigurasi yang berisi koneksi ke database
include("config.php");

// Ambil query pencarian dari URL
$query = $_GET['q'];

// Siapkan pernyataan SQL untuk mencari username yang mirip dengan query
$sql = "SELECT username FROM users WHERE username LIKE ?";

// Persiapkan SQL untuk dieksekusi
$stmt = $conn->prepare($sql);

// Tambahkan wildcard untuk pencarian yang fleksibel
$searchTerm = "%".$query."%";

// Ikat parameter ke pernyataan yang disiapkan
$stmt->bind_param("s", $searchTerm);

// Eksekusi pernyataan
$stmt->execute();

// Dapatkan hasil dari eksekusi
$result = $stmt->get_result();

// Inisialisasi array untuk menyimpan pengguna
$users = [];

// Loop melalui setiap baris hasil
while ($row = $result->fetch_assoc()) {
    // Tambahkan setiap baris ke array pengguna
    $users[] = $row;
}

// Encode array pengguna ke JSON dan output
echo json_encode($users);

// Tutup pernyataan
$stmt->close();

// Tutup koneksi database
$conn->close();
?>

