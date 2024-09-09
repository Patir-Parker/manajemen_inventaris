<?php
session_start(); // Mulai session
include 'db.php'; // Menghubungkan ke database

// Inisialisasi variabel
$id = '';
$nama_barang = '';
$jenis_pergerakan = '';
$jumlah = '';
$tanggal_pergerakan = '';

// Cek apakah ada ID yang dikirimkan untuk diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pergerakan inventaris berdasarkan ID
    $query = "SELECT inventaris.id, barang.nama_barang, inventaris.jenis_pergerakan, inventaris.jumlah, inventaris.tanggal_pergerakan 
              FROM inventaris 
              JOIN barang ON inventaris.id_barang = barang.id 
              WHERE inventaris.id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $nama_barang = $row['nama_barang'];
        $jenis_pergerakan = $row['jenis_pergerakan'];
        $jumlah = $row['jumlah'];
        $tanggal_pergerakan = $row['tanggal_pergerakan'];
    } else {
        $_SESSION['notif'] = 'Data pergerakan inventaris tidak ditemukan.';
        $_SESSION['notif_type'] = 'danger';
        header('Location: daftar_inventaris.php');
        exit;
    }
}

// Proses pengeditan setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_pergerakan = $_POST['jenis_pergerakan'];
    $jumlah = $_POST['jumlah'];
    $tanggal_pergerakan = $_POST['tanggal_pergerakan'];

    // Query untuk memperbarui data pergerakan inventaris
    $update_query = "UPDATE inventaris SET jenis_pergerakan='$jenis_pergerakan', jumlah='$jumlah', tanggal_pergerakan='$tanggal_pergerakan' WHERE id='$id'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['notif'] = 'Pergerakan inventaris berhasil diperbarui.';
        $_SESSION['notif_type'] = 'success';
        header('Location: daftar_inventaris.php');
        exit;
    } else {
        $_SESSION['notif'] = 'Gagal memperbarui pergerakan inventaris.';
        $_SESSION['notif_type'] = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pergerakan Inventaris</title>
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
        <h1>Edit Pergerakan Inventaris</h1>

        <!-- Tampilkan notifikasi jika ada -->
        <?php if (isset($_SESSION['notif'])): ?>
            <div class="alert alert-<?php echo $_SESSION['notif_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['notif']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['notif']); // Hapus notifikasi setelah ditampilkan ?>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="jenis_pergerakan">Jenis Pergerakan</label>
                <input type="text" class="form-control" id="jenis_pergerakan" name="jenis_pergerakan" value="<?php echo htmlspecialchars($jenis_pergerakan); ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($jumlah); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pergerakan">Tanggal Pergerakan</label>
                <input type="date" class="form-control" id="tanggal_pergerakan" name="tanggal_pergerakan" value="<?php echo htmlspecialchars($tanggal_pergerakan); ?>" required>
            </div>
            <button type="submit" class="btn btn-dark">Simpan Perubahan</button>
            <a href="daftar_inventaris.php" class="btn btn-outline-dark">Batal</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>