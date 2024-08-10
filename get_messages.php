<?php
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah pengguna sudah masuk atau belum
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $selectedGroup = $_POST['group'];

        // Query untuk mengambil pesan dari database berdasarkan grup yang dipilih
        $sql = "SELECT sender, message, timestamp FROM messages WHERE group_name = '$selectedGroup' ORDER BY timestamp DESC";
        $result = mysqli_query($conn, $sql);

        $messages = array();

        if (mysqli_num_rows($result) > 0) {
            // Mengisi array $messages dengan data pesan
            while ($row = mysqli_fetch_assoc($result)) {
                $messages[] = array(
                    'sender' => $row['sender'],
                    'message' => $row['message'],
                    'timestamp' => $row['timestamp']
                );
            }
        }

        // Mengembalikan data pesan dalam format JSON
        echo json_encode($messages);
    } else {
        echo "Silakan masuk untuk melihat pesan.";
    }
}
?>
