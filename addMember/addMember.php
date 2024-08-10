<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota ke Grup</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #131517;
            color: white;
            margin: 0;
            padding: 20px;
        }
        form {
            background-color: #212229;
            padding: 20px;
            border-radius: 10px;
        }
        label {
            margin-bottom: 10px;
        }
        select {
            width: 100%;
            padding: 8px;
            background-color: #383a46;
            color: white;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        button {
            background-color: #007BFF;
            color: white;   
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Tambah Teman ke Grup</h1>
    <form id="addMemberForm" method="post" action="addMemberToGroup.php">
        <label for="friend">Pilih Teman:</label>
        <select id="friend" name="friend">
            <?php
            session_start(); // Memulai sesi
            include("../config.php"); // Pastikan path ke config.php benar

            // Koneksi ke database
            $conn = new mysqli("localhost", "root", "", "aul");

            // Periksa koneksi
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Ambil user_id dari sesi
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            } else {
                echo "User tidak terautentikasi.";
                exit; // Hentikan eksekusi lebih lanjut jika tidak ada user_id di sesi
            }

            // Query untuk mengambil teman
            $sql = "SELECT u.user_id, u.username FROM users u
                    JOIN friends f ON f.user2_id = u.user_id
                    WHERE f.user1_id = $user_id;";
            $result = $conn->query($sql);

            // Menampilkan setiap teman sebagai opsi
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["user_id"] . "'>" . $row["username"] . "</option>";
                }
            } else {
                echo "<option>Tidak ada teman</option>";
            }
            ?>
        </select>

        <label for="group">Pilih Grup:</label>
        <select id="group" name="group">
            <?php
            // Query untuk mengambil grup
            $sql = "SELECT g.group_id, g.group_name FROM groups g
                    JOIN group_members gm ON gm.group_id = g.group_id
                    WHERE gm.user_id = $user_id;";
            $result = $conn->query($sql);

            // Menampilkan setiap grup sebagai opsi
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["group_id"] . "'>" . $row["group_name"] . "</option>";
                }
            } else {
                echo "<option>Tidak ada grup</option>";
            }

            $conn->close();
            ?>
        </select>

        <button type="submit">Tambahkan ke Grup</button>
    </form>

    <script>
        function addMemberToGroup() {
            const friend = document.getElementById('friend').value;
            const group = document.getElementById('group').value;
            console.log(`Menambahkan ${friend} ke ${group}`);
            // Implementasi lebih lanjut untuk menyimpan ke database atau server
        }
    </script>
</body>
</html>

