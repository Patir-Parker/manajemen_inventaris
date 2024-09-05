<?php
include 'db.php';
session_start(); // Mulai session

$id = $_GET['id'];

$query = "DELETE FROM pemasok WHERE id = $id";
if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Pemasok berhasil dihapus!";
    header('Location: pemasok.php');
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
