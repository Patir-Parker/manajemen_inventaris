<?php
include 'db.php';
session_start(); // Mulai session

$id = $_GET['id'];

$query = "DELETE FROM kategori WHERE id = $id";
if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Kategori berhasil dihapus!";
} else {
    $_SESSION['message'] = "Gagal menghapus kategori: " . mysqli_error($conn);
}

header('Location: kategori.php');
exit();
?>
