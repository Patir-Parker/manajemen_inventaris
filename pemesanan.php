<?php
include 'db.php'; // Menghubungkan ke database
session_start(); // Mulai session

// Inisialisasi variabel pencarian
$search = '';

// Cek apakah ada input pencarian
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query untuk mengambil data pemesanan dengan pencarian
$query = "SELECT Pemesanan.id, Barang.nama_barang, Pemesanan.tanggal_pemesanan, Pemesanan.jumlah 
          FROM Pemesanan 
          JOIN Barang ON Pemesanan.id_barang = Barang.id
          WHERE Barang.nama_barang LIKE '%$search%'
          ORDER BY pemesanan.id DESC";
$result = mysqli_query($conn, $query);

// Menyimpan data untuk menampilkan ID yang disesuaikan
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pemesanan</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Daftar Pemesanan</h1>
            
            <!-- Form Pencarian -->
            <form class="form-inline" method="get">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Cari</button>
            </form>
        </div>
        
        <a href="tambah_pemesanan.php" class="btn btn-outline-dark mb-3">Tambah Pemesanan</a>
        
        <!-- Tampilkan notifikasi jika ada -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message']); // Hapus pesan setelah ditampilkan ?>
        <?php endif; ?>

        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $index => $row): ?>
                    <tr>
                        <td><?php echo $index + 1; // Menampilkan ID yang disesuaikan ?></td>
                        <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal_pemesanan']); ?></td>
                        <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                        <td>
                        <a href="edit_pemesanan.php?id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm">Edit</a>
                            <a href="hapus_pemesanan.php?id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
