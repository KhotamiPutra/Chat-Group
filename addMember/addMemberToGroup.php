<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "aul");

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari POST
$friend_id = $_POST['friend'];
$group_id = $_POST['group'];
$role = 'member'; // Role otomatis sebagai 'member'

// Cek apakah user sudah ada di grup
$checkSql = "SELECT * FROM group_members WHERE user_id = ? AND group_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $friend_id, $group_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo "<script>alert('User sudah ada di dalam grup!');window.location.assign('../index.php');</script>";
} else {
    // Query untuk memasukkan user ke dalam grup
    $sql = "INSERT INTO group_members (user_id, group_id, role) VALUES (?, ?, ?)";

    // Persiapan untuk eksekusi query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $friend_id, $group_id, $role);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil ditambahkan ke grup!');window.location.assign('../index.php');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

// Tutup statement cek dan koneksi
$checkStmt->close();
$conn->close();
?>