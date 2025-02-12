<?php
include "config.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $conn->query("UPDATE tasks SET status=$status WHERE id=$id");
}

$conn->close();
?>
