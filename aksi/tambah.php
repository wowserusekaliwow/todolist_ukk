<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = $_POST["nama_tugas"];
    $tanggal = $_POST["tanggal"];
    $prioritas = $_POST["prioritas"];

    $stmt = $conn->prepare("INSERT INTO tasks (nama_tugas, tanggal, prioritas) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama_tugas, $tanggal, $prioritas);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <link rel="stylesheet" href="../css/styles-tambahedit.css">
</head>
<body>

    <div class="container">
        <h1>Tambah <span class="highlight">Tugas</span></h1>

        <form method="POST">
            <label for="nama_tugas">Nama Tugas</label>
            <input type="text" id="nama_tugas" name="nama_tugas" placeholder="Masukkan nama tugas" required>

            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" required>

            <label for="prioritas">Prioritas</label>
            <select id="prioritas" name="prioritas">
                <option value="Tinggi">Tinggi</option>
                <option value="Sedang">Sedang</option>
                <option value="Rendah">Rendah</option>
            </select>

            <button type="submit">Simpan</button>
        </form>
    </div>

</body>
</html>
