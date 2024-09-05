<?php
session_start(); // Mulai session

$tanggal_hari_ini = date('Y-m-d');

include 'db.php'; // Menghubungkan ke database

if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $jenis_pergerakan = $_POST['jenis_pergerakan'];
    $jumlah = $_POST['jumlah'];
    $tanggal_pergerakan = $_POST['tanggal_pergerakan'];

    // Query untuk menambah pergerakan ke tabel Inventaris
    $query = "INSERT INTO inventaris (id_barang, jenis_pergerakan, jumlah, tanggal_pergerakan) 
              VALUES ('$id_barang', '$jenis_pergerakan', '$jumlah', '$tanggal_pergerakan')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Set notifikasi berhasil
        $_SESSION['notif'] = "Pergerakan inventaris berhasil ditambahkan!";
        $_SESSION['notif_type'] = "success";
        header("Location: daftar_inventaris.php");
        exit();
    } else {
        // Set notifikasi gagal
        $_SESSION['notif'] = "Gagal menambahkan pergerakan inventaris.";
        $_SESSION['notif_type'] = "danger";
        header("Location: daftar_inventaris.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pergerakan Inventaris</title>
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
    <!-- Navbar -->
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

    <!-- Konten -->
    <div class="container mt-4">
        <h1>Tambah Pergerakan Inventaris</h1>
        <form method="post">
            <div class="form-group">
                <label for="id_barang">Barang:</label>
                <select name="id_barang" id="id_barang" class="form-control" required>
                    <?php
                    $barang = mysqli_query($conn, "SELECT * FROM Barang");
                    while ($row = mysqli_fetch_assoc($barang)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nama_barang'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_pergerakan">Jenis Pergerakan:</label>
                <select name="jenis_pergerakan" id="jenis_pergerakan" class="form-control" required>
                    <option value="Masuk">Masuk</option>
                    <option value="Keluar">Keluar</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pergerakan">Tanggal Pergerakan:</label>
                <input type="date" name="tanggal_pergerakan" id="tanggal_pergerakan" class="form-control" 
                value="<?php echo $tanggal_hari_ini; ?>"
                min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-dark">Tambah Pergerakan</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
