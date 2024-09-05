<?php
include 'db.php';
session_start(); // Mulai session

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM barang WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $barang = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {
        $nama_barang = $_POST['nama_barang'];
        $id_kategori = $_POST['id_kategori'];
        $id_pemasok = $_POST['id_pemasok'];
        $jumlah = $_POST['jumlah'];
        $tanggal_pembelian = $_POST['tanggal_pembelian'];

        $query = "UPDATE barang SET 
                  nama_barang='$nama_barang', 
                  id_kategori='$id_kategori', 
                  id_pemasok='$id_pemasok', 
                  jumlah='$jumlah', 
                  tanggal_pembelian='$tanggal_pembelian' 
                  WHERE id='$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['message'] = "Data berhasil diperbarui!";
            header("Location: barang.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Gagal memperbarui barang.</div>";
        }
    }
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori");
$pemasok = mysqli_query($conn, "SELECT * FROM pemasok");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <!-- Bootstrap CSS -->
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

    <div class="container mt-4">
        <h1>Edit Barang</h1>
        <form method="post">
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($barang['nama_barang']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="id_kategori">Kategori:</label>
                <select class="form-control" id="id_kategori" name="id_kategori" required>
                    <?php while($row = mysqli_fetch_assoc($kategori)): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $barang['id_kategori']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['nama_kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_pemasok">Pemasok:</label>
                <select class="form-control" id="id_pemasok" name="id_pemasok" required>
                    <?php while($row = mysqli_fetch_assoc($pemasok)): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $barang['id_pemasok']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['nama_pemasok']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($barang['jumlah']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian:</label>
                <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="<?php echo htmlspecialchars($barang['tanggal_pembelian']); ?>" required>
            </div>
            
            <button type="submit" name="submit" class="btn btn-dark">Perbarui Barang</button>
            <a href="barang.php" class="btn btn-dark">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
