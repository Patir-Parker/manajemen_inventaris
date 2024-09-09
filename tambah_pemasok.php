<?php
include 'db.php';
session_start(); // Mulai session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemasok = $_POST['nama_pemasok'];
    $info_kontak = $_POST['info_kontak'];

    // Cek apakah email sudah ada
    $checkEmailQuery = "SELECT * FROM pemasok WHERE info_kontak = '$info_kontak'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['message'] = "Email sudah terdaftar!";
        $_SESSION['alert_type'] = "warning"; // Kuning untuk peringatan
    } else {
        // Jika email tidak ada, tambahkan ke database
        $query = "INSERT INTO pemasok (nama_pemasok, info_kontak) VALUES ('$nama_pemasok', '$info_kontak')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "Pemasok berhasil ditambahkan!";
            header('Location: pemasok.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    header('Location: tambah_pemasok.php'); // Kembali ke halaman tambah jika ada masalah
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pemasok</title>
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
        <h1>Tambah Pemasok</h1>
        
        <!-- Notifikasi Pesan -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message'], $_SESSION['alert_type']); // Hapus pesan setelah ditampilkan
                ?>
            </div>
        <?php endif; ?>

        <form action="tambah_pemasok.php" method="post">
            <div class="form-group">
                <label for="nama_pemasok">Nama Pemasok</label>
                <input type="text" class="form-control" id="nama_pemasok" name="nama_pemasok" required>
            </div>
            <div class="form-group">
                <label for="info_kontak">E-Mail</label>
                <input type="email" class="form-control" id="info_kontak" name="info_kontak" required>
            </div>
            <button type="submit" class="btn btn-dark">Simpan</button>
            <a href="pemasok.php" class="btn btn-dark">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>