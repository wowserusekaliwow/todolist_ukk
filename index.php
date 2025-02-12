<?php
include "aksi/config.php"; // Koneksi ke database

// Fungsi untuk format tanggal ke Bahasa Indonesia
function formatTanggal($tanggal)
{
    $formatter = new IntlDateFormatter(
        'id_ID',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'Asia/Jakarta',
        IntlDateFormatter::GREGORIAN,
        'EEEE, d MMMM yyyy'
    );

    return $formatter->format(new DateTime($tanggal));
}

// Ambil data dari database dengan prioritas tinggi di atas
$result = $conn->query("SELECT * FROM tasks 
    ORDER BY 
        CASE 
            WHEN prioritas = 'Tinggi' THEN 1
            WHEN prioritas = 'Sedang' THEN 2
            ELSE 3
        END, 
    tanggal ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <h1>To do <span class="highlight">List</span></h1>
    <button class="add-task" onclick="location.href='aksi/tambah.php'">+</button>

    <table>
        <thead>
            <tr>
                <th>Nama Tugas</th>
                <th>Tanggal</th>
                <th>Prioritas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="task-container">
                            <button class="checkbox-btn <?= $row['status'] ? 'checked' : '' ?>" onclick="toggleStatus(<?= $row['id'] ?>, <?= $row['status'] ?>)">
                                <i class='bx <?= $row['status'] ? "bx-checkbox-checked" : "bx-checkbox" ?>'></i>
                            </button>
                            <span class="<?= $row['status'] ? 'completed' : '' ?>">
                                <?= htmlspecialchars($row['nama_tugas']) ?>
                            </span>
                        </div>
                    </td>
                    <td class="<?= $row['status'] ? 'completed' : '' ?>">
                        <?= formatTanggal($row['tanggal']) ?>
                    </td>
                    <td class="prioritas <?= $row['status'] ? 'opacity-low' : '' ?> 
                    <?php
                    if ($row['prioritas'] == 'Tinggi') echo 'priority-high';
                    else if ($row['prioritas'] == 'Sedang') echo 'priority-medium';
                    else echo 'priority-low';
                    ?>
                ">
                        <?= $row['prioritas'] ?>
                    </td>
                    <td>
                        <div class="aksi-container">
                            <button class="edit"
                                onclick="location.href='aksi/edit.php?id=<?= $row['id'] ?>'"
                                <?= $row['status'] ? 'disabled' : '' ?>>
                                Edit
                            </button>
                            <button class="delete" onclick="hapusTugas(<?= $row['id'] ?>)">Hapus</button>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        function toggleStatus(id, status) {
            fetch('aksi/toggle_status.php?id=' + id + '&status=' + (status ? 0 : 1))
                .then(response => response.text())
                .then(data => {
                    location.reload();
                });
        }

        function hapusTugas(id) {
            if (confirm("Yakin ingin menghapus tugas ini?")) {
                fetch('aksi/hapus.php?id=' + id)
                    .then(response => response.text())
                    .then(data => {
                        location.reload();
                    });
            }
        }
    </script>

</body>

</html>