<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "todolist_ukk";

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
