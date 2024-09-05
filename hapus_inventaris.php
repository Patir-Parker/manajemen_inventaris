<?php
session_start(); // Mulai session

include 'db.php'; // Menghubungkan ke database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus pergerakan inventaris berdasarkan ID
    $query = "DELETE FROM inventaris WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Set notifikasi berhasil
        $_SESSION['notif'] = "Pergerakan inventaris berhasil dihapus!";
        $_SESSION['notif_type'] = "success";
    } else {
        // Set notifikasi gagal
        $_SESSION['notif'] = "Gagal menghapus pergerakan inventaris.";
        $_SESSION['notif_type'] = "danger";
    }

    header("Location: daftar_inventaris.php");
    exit();
}
?>
