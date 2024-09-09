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

// Fetch pemasok
$query = "SELECT * FROM pemasok WHERE nama_pemasok LIKE '%$search%'
        ORDER BY pemasok.id DESC";
$result = mysqli_query($conn, $query);

// Menyimpan data untuk menampilkan ID yang disesuaikan
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Hapus data berdasarkan ID
    $deleteQuery = "DELETE FROM pemasok WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);

    try {
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Pemasok berhasil dihapus!";
        } else {
            // Cek apakah error karena foreign key constraint
            if (mysqli_errno($conn) == 1451) {
                $_SESSION['message'] = "Data sedang digunakan. Tidak dapat menghapus kategori ini.";
            } else {
                $_SESSION['message'] = "Gagal menghapus kategori.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Kesalahan: Data sedang digunakan. Tidak dapat menghapus pemasok";
    }

    mysqli_stmt_close($stmt);
    header("Location: pemasok.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pemasok</title>
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
            <h1 class="mb-0">Daftar Pemasok</h1>
            
            <!-- Form Pencarian -->
            <form class="form-inline" method="get">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-dark" type="submit">Cari</button>
            </form>
        </div>
        <a href="tambah_pemasok.php" class="btn btn-outline-dark mb-3">Tambah Pemasok</a>
        <?php if ($message): ?>
            <div class="notif-container mt-4">
                <div class='alert alert-secondary alert-dismissible fade show' role='alert'>
                    <?php echo $message; ?>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Pemasok</th>
                    <th>E-Mail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $index => $row): ?>
                    <tr>
                        <td><?php echo $index + 1; // Menampilkan ID yang disesuaikan ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pemasok']); ?></td>
                        <td><?php echo htmlspecialchars($row['info_kontak']); ?></td>
                        <td>
                            <a href="edit_pemasok.php?id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm">Edit</a>
                            <a href="hapus_pemasok.php?id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pemasok ini?')">Hapus</a>
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
