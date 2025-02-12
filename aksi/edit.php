<?php
include "config.php";

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;

// Ambil data tugas berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

// Jika data tidak ditemukan, redirect ke index.php
if (!$task) {
    header("Location: index.php");
    exit();
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = $_POST["nama_tugas"];
    $tanggal = $_POST["tanggal"];
    $prioritas = $_POST["prioritas"];

    $stmt = $conn->prepare("UPDATE tasks SET nama_tugas = ?, tanggal = ?, prioritas = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nama_tugas, $tanggal, $prioritas, $id);
    $stmt->execute();

    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="../css/styles-tambahedit.css">
</head>
<body>

    <div class="container">
        <h1>Edit <span class="highlight">Tugas</span></h1>

        <form method="POST">
            <label for="nama_tugas">Nama Tugas</label>
            <input type="text" id="nama_tugas" name="nama_tugas" value="<?= htmlspecialchars($task['nama_tugas']) ?>" required>

            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="<?= $task['tanggal'] ?>" required>

            <label for="prioritas">Prioritas</label>
            <select id="prioritas" name="prioritas">
                <option value="Tinggi" <?= $task['prioritas'] == 'Tinggi' ? 'selected' : '' ?>>Tinggi</option>
                <option value="Sedang" <?= $task['prioritas'] == 'Sedang' ? 'selected' : '' ?>>Sedang</option>
                <option value="Rendah" <?= $task['prioritas'] == 'Rendah' ? 'selected' : '' ?>>Rendah</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>

</body>
</html>
