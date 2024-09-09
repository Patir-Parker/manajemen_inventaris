<?php
include 'db.php'; // Menghubungkan ke database

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Hapus data berdasarkan ID
    $deleteQuery = "DELETE FROM barang WHERE id = $delete_id";

    try {
        mysqli_query($conn, $deleteQuery);
        $_SESSION['message'] = "Barang berhasil dihapus!";
    } catch (mysqli_sql_exception $e) {
        // Cek apakah error karena foreign key constraint
        if ($e->getCode() == 1451) { // 1451: Cannot delete or update a parent row: a foreign key constraint fails
            $_SESSION['message'] = "Data sedang digunakan. Tidak dapat menghapus barang ini.";
        } else {
            $_SESSION['message'] = "Gagal menghapus barang: " . $e->getMessage();
        }
    }

    header("Location: barang.php");
    exit();
}else {
        echo "Gagal menghapus barang.";
    }

?>


