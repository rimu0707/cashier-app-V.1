<?php
include 'koneksi.php';

$nama_petugas = '';
if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $nama_petugas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_petugas FROM petugas WHERE username = '$username'"))['nama_petugas'] ?? '';
}
?>

<link rel="stylesheet" href="../css/sidebar.css">

<div class="sidebar floating-sidebar d-flex flex-column p-3">
  <!-- isi sidebar tetap -->
  <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
    <img src="../assets/kasir-32x32.png" alt="Logo" width="32" height="32" class="me-2">
    <span class="fs-5 fw-semibold text-primary">Cashier App</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li><a href="dashboard.php" class="nav-link text-dark"><i class="bi bi-house-fill me-2"></i>Dashboard</a></li>
    <li><a href="penjualan.php" class="nav-link text-dark"><i class="bi bi-cart-fill me-2"></i>Penjualan</a></li>
    <li><a href="data-barang.php" class="nav-link text-dark"><i class="bi bi-box-seam-fill me-2"></i>Data Barang</a></li>
    <li><a href="data-penjualan.php" class="nav-link text-dark"><i class="bi bi-cart-check-fill me-2"></i>Data Penjualan</a></li>
    <li><a href="data-pelanggan.php" class="nav-link text-dark"><i class="bi bi-people-fill"></i></i> Data Pelanggan</a></li>
  </ul>
  <hr>
  <a href="../config/logout.php" class="text-danger text-decoration-none"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
  <div class="mt-3 text-dark">
    <i class="bi bi-person-circle me-2"></i>Selamat Datang Petugas : <strong><?= htmlspecialchars($nama_petugas ?? '') ?></strong>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVZbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">