<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->query("DELETE FROM tasks WHERE id=$id");
}

$conn->close();
?>
