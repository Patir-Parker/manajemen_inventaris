<?php
include 'db.php';
session_start(); // Mulai session

// Ambil pesan jika ada
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}

// Inisialisasi variabel pencarian
$search = '';

// Cek apakah ada input pencarian
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Ubah query untuk pencarian
$query = "SELECT barang.id, barang.nama_barang, kategori.nama_kategori, pemasok.nama_pemasok, barang.jumlah, barang.tanggal_pembelian 
          FROM barang 
          JOIN kategori ON barang.id_kategori = kategori.id 
          JOIN pemasok ON barang.id_pemasok = pemasok.id
          WHERE barang.nama_barang LIKE '%$search%' 
          OR kategori.nama_kategori LIKE '%$search%' 
          OR pemasok.nama_pemasok LIKE '%$search%'
          ORDER BY barang.id DESC";

$result = mysqli_query($conn, $query);

// Menyimpan data untuk menampilkan ID yang disesuaikan
$items = [];
while($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

// Fungsi untuk menghapus data barang
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Hapus data berdasarkan ID
    $deleteQuery = "DELETE FROM barang WHERE id = $delete_id";

    try {
        if (mysqli_query($conn, $deleteQuery)) {
            $_SESSION['message'] = "Barang berhasil dihapus!";
        } else {
            // Cek apakah error karena foreign key constraint
            if (mysqli_errno($conn) == 1451) {
                $_SESSION['message'] = "Data sedang digunakan. Tidak dapat menghapus barang ini.";
            } else {
                $_SESSION['message'] = "Gagal menghapus barang.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Kesalahan: " . $e->getMessage();
    }

    header("Location: barang.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Inventaris Barang</title>
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
        .table-container {
            max-height: 450px;
            overflow-y: auto;
        }
        .table-fixed {
            position: relative;
        }
        .table-fixed thead th {
            position: sticky;
            top: 0;
            background-color: #343a40;
            color: white;
            z-index: 0;
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
            <h1 class="mb-0">Daftar Barang</h1>
            
            <!-- Form Pencarian -->
            <form class="form-inline" method="get">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-dark" type="submit">Cari</button>
            </form>
        </div>
        
        <a href="tambah_barang.php" class="btn btn-outline-dark mb-3">Tambah Barang</a>
        
        <?php if ($message): ?>
            <div class="notif-container mt-4">
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <?php echo $message; ?>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="table-container">
        <table class="table table-bordered table-hover table-striped table-fixed">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Pemasok</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pembelian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $index => $row): ?>
                    <tr>
                        <td><?php echo $index + 1; // Menampilkan ID yang disesuaikan ?></td>
                        <td><?php echo $row['nama_barang']; ?></td>
                        <td><?php echo $row['nama_kategori']; ?></td>
                        <td><?php echo $row['nama_pemasok']; ?></td>
                        <td><?php echo $row['jumlah']; ?></td>
                        <td><?php echo $row['tanggal_pembelian']; ?></td>
                        <td>
                            <a href="edit_barang.php?id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm">Edit</a>
                            <a href="barang.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
