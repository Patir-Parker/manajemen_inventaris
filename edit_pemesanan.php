<?php
include 'db.php'; // Menghubungkan ke database
session_start(); // Mulai session

// Inisialisasi variabel
$id = '';
$nama_barang = '';
$tanggal_pemesanan = '';
$jumlah = '';

// Cek apakah ada ID yang dikirimkan untuk diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pemesanan berdasarkan ID
    $query = "SELECT Pemesanan.id, Barang.nama_barang, Pemesanan.tanggal_pemesanan, Pemesanan.jumlah 
              FROM Pemesanan 
              JOIN Barang ON Pemesanan.id_barang = Barang.id 
              WHERE Pemesanan.id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $nama_barang = $row['nama_barang'];
        $tanggal_pemesanan = $row['tanggal_pemesanan'];
        $jumlah = $row['jumlah'];
    } else {
        $_SESSION['message'] = 'Data pemesanan tidak ditemukan.';
        header('Location: pemesanan.php');
        exit;
    }
}

// Proses pengeditan setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
    $jumlah = $_POST['jumlah'];

    // Query untuk memperbarui data pemesanan
    $update_query = "UPDATE Pemesanan SET tanggal_pemesanan='$tanggal_pemesanan', jumlah='$jumlah' WHERE id='$id'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = 'Pemesanan berhasil diperbarui.';
        header('Location: pemesanan.php');
        exit;
    } else {
        $_SESSION['message'] = 'Gagal memperbarui pemesanan.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pemesanan</title>
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Edit Pemesanan</h1>

        <!-- Tampilkan notifikasi jika ada -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message']); // Hapus pesan setelah ditampilkan ?>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" value="<?php echo htmlspecialchars($tanggal_pemesanan); ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($jumlah); ?>" required>
            </div>
            <button type="submit" class="btn btn-dark">Simpan Perubahan</button>
            <a href="pemesanan.php" class="btn btn-outline-dark">Batal</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>