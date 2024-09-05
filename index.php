<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
        }
        
        .navbar {
            padding: 1rem;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url('https://source.unsplash.com/1600x900/?technology,city') no-repeat center center;
            background-size: cover;
            color: black;
            padding: 50px 0;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeInDown 1s;
        }
        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            animation: fadeInUp 1.5s;
        }
        .hero-section a {
            padding: 15px 30px;
            font-size: 1.2rem;
            animation: fadeInUp 2s;
        }
        .features-section {
            padding: 40px 0;
        }
        .feature-card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s;
            box-shadow: 0 5px 20px rgba(200, 200, 200, 1);
            text-align: center;
            padding: 2rem;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 5px 20px rgba(141, 141, 141, 1);
        }
        .feature-card i {
            font-size: 3rem;
            color: #000;
            margin-bottom: 20px;
        }
        .feature-card h4 {
            margin: 20px 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: black
        }
        .feature-card p {
            font-size: 1rem;
            color: #666;
        }
        .about-section {
            padding: 80px 0;
            background-color: #f7f7f7;
            text-align: center;
        }
        .about-section h2 {
            margin-bottom: 40px;
        }
        .about-section p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .contact-section {
            padding: 80px 0;
        }
        .contact-section h2 {
            text-align: center;
            margin-bottom: 50px;
        }
        .contact-section form {
            max-width: 600px;
            margin: 0 auto;
        }
        .contact-section .form-control {
            margin-bottom: 20px;
        }
        .contact-section button {
            padding: 15px;
            font-size: 1.2rem;
        }
        footer {
            background-color: #333;
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        footer p {
            margin: 0;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Manajemen Inventaris</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
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
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>Manajemen Inventaris</h1>
            <p>Mempermudah User Untuk Mencatat Barang Barang</p>
            <a href="barang.php" class="btn btn-dark btn-lg">Mulai</a>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                <a href="barang.php" class="text-decoration-none">
                    <div class="card feature-card">
                        <div class="card-body">
                            <i class="fas fa-cube"></i>
                            <h4 class="card-title">Barang</h4>
                            <!-- <p class="card-text">Menampilkan Halaman Barang</p> -->
                        </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3 mb-4">
                <a href="kategori.php" class="text-decoration-none">
                    <div class="card feature-card">
                        <div class="card-body">
                            <i class="fas fa-tasks"></i>
                            <h4 class="card-title">Kategori</h4>
                            <!-- <p class="card-text">Menampilkan Halaman Kategori Barang</p> -->
                        </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3 mb-4">
                <a href="pemasok.php" class="text-decoration-none">
                    <div class="card feature-card">
                        <div class="card-body">
                            <i class="fa fa-user-secret"></i>
                            <h4 class="card-title">Pemasok</h4>
                            <!-- <p class="card-text">Menampilkan Halaman Nama Nama Pemasok</p> -->
                        </div>
                    </div>
                   </a>
                </div>
                <div class="col-md-3 mb-4">
                    <a href="pemesanan.php" class="text-decoration-none">
                    <div class="card feature-card">
                        <div class="card-body">
                            <i class="fa fa-shopping-cart" ></i>
                            <h4 class="card-title">Pemesanan</h4>
                            <!-- <p class="card-text">Menampilkan Halaman Pemesanan Barang</p> -->
                        </div>
                    </div>
                  </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
