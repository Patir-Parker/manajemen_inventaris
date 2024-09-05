<?php
include 'db.php'; // Menghubungkan ke database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus barang berdasarkan ID
    $deleteQuery = "DELETE FROM barang WHERE id='$id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Update id dari baris yang tersisa
        $updateQuery = "SET @id := 0;
                        UPDATE barang
                        SET id = (@id := @id + 1)
                        ORDER BY id";
        mysqli_query($conn, $updateQuery);

        // Reset auto increment
        $resetAIQuery = "ALTER TABLE barang AUTO_INCREMENT = 1";
        mysqli_query($conn, $resetAIQuery);

        // Set message dan redirect
        session_start();
        $_SESSION['message'] = "Barang berhasil dihapus dan ID diperbarui.";
        header("Location: barang.php");
        exit();
    } else {
        echo "Gagal menghapus barang.";
    }
}
?>


