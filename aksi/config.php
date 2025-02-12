<?php
$host = "localhost"; // Sesuaikan jika menggunakan hosting
$user = "root"; // Username MySQL (default: root)
$pass = ""; // Password MySQL (default kosong di XAMPP)
$db = "todolist_ukk"; // Nama database

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
