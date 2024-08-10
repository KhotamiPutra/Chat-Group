<?php
// send_message.php

include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $message = $_POST['message'];
        $selectedGroup = $_POST['group'];

        // Simpan pesan ke dalam database
        $sql = "INSERT INTO messages (group_name, sender, message) VALUES ('$selectedGroup', '$username', '$message')";

        if (mysqli_query($conn, $sql)) {
            echo "Pesan berhasil dikirim.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Silakan masuk untuk mengirim pesan.";
    }
}

?>
