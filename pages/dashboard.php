<?php
session_start();
include '../config/koneksi.php';


$jumlah_pengguna = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT id_petugas) AS total FROM petugas"))['total'] ?? 0;

$jumlah_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT ProdukID) AS total FROM produk"))['total'] ?? 0;

$jumlah_penjualan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT PenjualanID) AS total FROM penjualan"))['total'] ?? 0;
$jumlah_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT PelangganID) AS total FROM pelanggan"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <?php
    if ($_SESSION['level'] === 'admin') {
        include '../config/sidebar-admin.php';
    } elseif ($_SESSION['level'] === 'petugas') {
        include '../config/sidebar-petugas.php';
    } else {
        echo "Level user tidak dikenal.";
        exit;
    }
    ?>
<div class="main-content flex-grow-1 p-3" style="margin-left: 270px; padding: 2rem";>
        <h2 class="mb-4">Dashboard</h2>
        <div class="row">
            <!-- Jumlah Pengguna -->
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3 shadow rounded">
                    <div class="card-body">
                        <h4 class="card-title"><i class="bi bi-people-fill"></i> Jumlah Pengguna</h4>
                        <h1 class="card-text text-left">
                            <?php echo $jumlah_pengguna ?? 0; ?>
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Jumlah Barang -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 shadow rounded">
                    <div class="card-body">
                        <h4 class="card-title"><i class="bi bi-box-seam-fill"></i> Jumlah Barang</h4>
                        <h1 class="card-text text-left">
                            <?php echo $jumlah_barang ?? 0; ?>
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Jumlah Penjualan -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3 shadow rounded">
                    <div class="card-body">
                        <h4 class="card-title"><i class="bi bi-bag-check-fill"></i> Jumlah Penjualan</h4>
                        <h1 class="card-text text-left">
                            <?php echo $jumlah_penjualan ?? 0; ?>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3 shadow rounded">
                    <div class="card-body">
                        <h4 class="card-title"><i class="bi bi-people-fill"></i> Jumlah Pelanggan</h4>
                        <h1 class="card-text text-left">
                            <?php echo $jumlah_pelanggan ?? 0; ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</html>
