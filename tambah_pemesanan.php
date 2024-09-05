<?php
include 'db.php';
session_start(); // Mulai session

$tanggal_hari_ini = date('Y-m-d');

if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
    $jumlah = $_POST['jumlah'];

    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        // Query untuk menambah pemesanan ke tabel Pemesanan
        $query = "INSERT INTO Pemesanan (id_barang, tanggal_pemesanan, jumlah) VALUES ('$id_barang', '$tanggal_pemesanan', '$jumlah')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Gagal menambahkan pemesanan.");
        }

        // Query untuk mengurangi jumlah barang yang tersedia
        $updateQuery = "UPDATE barang SET jumlah = jumlah - $jumlah WHERE id = $id_barang";
        $updateResult = mysqli_query($conn, $updateQuery);

        if (!$updateResult) {
            throw new Exception("Gagal memperbarui jumlah barang.");
        }

        // Commit transaksi
        mysqli_commit($conn);

        // Set notifikasi sukses
        $_SESSION['message'] = "Pemesanan berhasil ditambahkan!";
        header("Location: pemesanan.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        mysqli_rollback($conn);
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pemesanan</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
        }
        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
        }
        .btn-dark:hover {
            background-color: #23272b;
            border-color: #23272b;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Manajemen Inventaris</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="barang.php">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kategori.php">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pemasok.php">Pemasok</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pemesanan.php">Pemesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="daftar_inventaris.php">Inventaris</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Tambah Pemesanan</h1>
        <form method="post">
            <div class="form-group">
                <label for="id_barang">Barang:</label>
                <select name="id_barang" id="id_barang" class="form-control" required>
                    <?php
                    $barang = mysqli_query($conn, "SELECT * FROM Barang");
                    while ($row = mysqli_fetch_assoc($barang)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nama_barang'] .  "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
                <input type="date" name="tanggal_pemesanan" id="tanggal_pemesanan" class="form-control" 
                value="<?php echo $tanggal_hari_ini; ?>"
                min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
            </div>
            <button type="submit" name="submit" class="btn btn-dark">Tambah Pemesanan</button>
            <a href="pemesanan.php" class="btn btn-dark">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
