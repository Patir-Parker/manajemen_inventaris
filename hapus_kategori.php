<?php
include 'db.php';
session_start();

if (isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);

    // Hapus data berdasarkan ID
    $deleteQuery = "DELETE FROM kategori WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);

    try {
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Kategori berhasil dihapus!";
        } else {
            // Cek apakah error karena foreign key constraint
            if (mysqli_errno($conn) == 1451) {
                $_SESSION['message'] = "Data sedang digunakan. Tidak dapat menghapus kategori ini.";
            } else {
                $_SESSION['message'] = "Gagal menghapus kategori.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Kesalahan: " . $e->getMessage();
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['message'] = "ID kategori tidak valid.";
}

header("Location: kategori.php");
exit();
?>