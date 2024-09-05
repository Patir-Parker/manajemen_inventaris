<?php
include 'db.php';
session_start(); // Mulai session

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus pemesanan berdasarkan ID
    $query = "DELETE FROM Pemesanan WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Set notifikasi sukses
        $_SESSION['message'] = "Pemesanan berhasil dihapus!";
        header("Location: pemesanan.php");
        exit();
    } else {
        echo "Gagal menghapus pemesanan.";
    }
}
?>
