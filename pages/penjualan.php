<?php
include '../config/koneksi.php';
include '../config/proses-transaksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-cart-check-fill me-2"></i>Penjualan</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php
                if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == "simpan") {
                        echo '<div class="alert alert-success">Data Berhasil Disimpan</div>';
                    } elseif ($_GET['pesan'] == "hapus") {
                        echo '<div class="alert alert-success">Data Berhasil Dihapus</div>';
                    } elseif ($_GET['pesan'] == "gagal") {
                        echo '<div class="alert alert-danger">Barang Tidak Ditemukan</div>';
                    }
                }
                ?>
                <label for="barcode" class="form-label">Scan Barcode</label>
                <input class="form-control" id="barcode" name="barcode" type="text" placeholder="Masukkan Barcode">
                <button type="submit" class="btn btn-primary mt-2">Tambah ke Keranjang</button>
            </form>

            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['keranjang'] as $key => $item) {
                            $subtotal = $item['Harga'] * $item['Jumlah'];
                            $total += $subtotal;
                            echo "
                            <tr>
                                <td>{$item['NamaProduk']}</td>
                                <td>Rp " . number_format($item['Harga'], 0, ',', '.') . "</td>
                                <td>{$item['Jumlah']}</td>
                                <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- FORM PELANGGAN -->
                <form action="../config/proses-transaksi.php" method="POST" class="mt-4" id="formTransaksi "data-keranjang="<?php echo empty($_SESSION['keranjang']) ? 'false' : 'true'; ?>">
                    <label for="searchPelanggan" class="form-label">Cari ID Pelanggan</label>
                    <div class="input-group mb-2">
                        <input class="form-control" id="searchPelanggan" type="text" placeholder="Masukkan ID Pelanggan">
                        <button class="btn btn-primary" type="button" id="btnCariPelanggan">Cari</button>
                    </div>
                    <input type="hidden" name="searchPelanggan" id="inputSearchPelanggan" value="<?php echo $pelanggan['PelangganID'] ?? '' ?>">
                    <ul id="listPelanggan" class="list-group mb-3"></ul>

                    <label for="namapelanggan" class="form-label">Nama Pelanggan</label>
                    <input class="form-control" id="NamaPelanggan" name="NamaPelanggan" type="text" placeholder="Nama Pelanggan" readonly value="<?php echo htmlspecialchars($pelanggan['NamaPelanggan'] ?? '') ?>">

                    <label for="alamat" class="form-label mt-3">Alamat</label>
                    <input class="form-control" id="Alamat" name="Alamat" type="text" placeholder="Alamat Pelanggan" readonly value="<?php echo htmlspecialchars($pelanggan['Alamat'] ?? '') ?>">

                    <label for="telepon" class="form-label mt-3">Telepon</label>
                    <input class="form-control" id="NomorTelepon" name="NomorTelepon" type="text" placeholder="Telepon Pelanggan" readonly value="<?php echo htmlspecialchars($pelanggan['NomorTelepon'] ?? '') ?>">

                    <!-- Total & Pembayaran -->
                    <label for="total" class="form-label mt-3">Total Pembelian</label>
                    <input class="form-control" id="total" type="text" value="Rp <?php echo number_format($total, 0, ',', '.') ?>" readonly>
                    <input type="hidden" id="total-pembelian" name="total" value="<?php echo $total; ?>">

                    <label for="bayar" class="form-label mt-3">Jumlah Uang</label>
                    <input class="form-control" id="bayar" name="bayar" type="number" placeholder="Masukkan jumlah uang" oninput="hitungKembalian()">

                    <label for="kembalian" class="form-label mt-3">Kembalian</label>
                    <input class="form-control" id="kembalian" type="text" readonly>
                    <br>

                    <button type="submit" name="simpan" class="btn btn-success">Bayar</button>
                    <button type="submit" name="hapus" class="btn btn-danger">Hapus Semua</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../javascript/transaksi.js"></script>

</body>
</html>
