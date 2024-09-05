<?php
include 'db.php';
session_start(); // Mulai session

$id = $_GET['id'];
$query = "SELECT * FROM pemasok WHERE id = $id";
$result = mysqli_query($conn, $query);
$supplier = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemasok = $_POST['nama_pemasok'];
    $info_kontak = $_POST['info_kontak'];

    $query = "UPDATE pemasok SET nama_pemasok='$nama_pemasok', info_kontak='$info_kontak' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Pemasok berhasil diperbarui!";
        header('Location: pemasok.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemasok</title>
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
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <h1>Edit Pemasok</h1>
        <form action="edit_pemasok.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="nama_pemasok">Nama Pemasok</label>
                <input type="text" class="form-control" id="nama_pemasok" name="nama_pemasok" value="<?php echo htmlspecialchars($supplier['nama_pemasok']); ?>" required>
            </div>
            <div class="form-group">
                <label for="info_kontak">E-Mail</label>
                <input type="email" class="form-control" id="info_kontak" name="info_kontak" value="<?php echo htmlspecialchars($supplier['info_kontak']); ?>" required>
            </div>
            <button type="submit" class="btn btn-dark">Update</button>
            <a href="pemasok.php" class="btn btn-dark">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
