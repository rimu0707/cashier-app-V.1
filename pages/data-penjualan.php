<?php
session_start();
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0"><i class="bi bi-cart-check-fill me-2"></i>Data Penjualan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table" style="background-color: #e3f2fd;">
                            <tr>
                                <th>No</th>
                                <th>Penjualan ID</th>
                                <th>Tanggal Penjualan</th>
                                <th>Nama Produk</th>
                                <th>ID Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                                $query = "SELECT dp.*, p.PelangganID 
                                FROM detailpenjualan dp
                                JOIN penjualan p ON dp.PenjualanID = p.PenjualanID
                                ORDER BY dp.DetailID DESC";
                                $data = mysqli_query($conn, $query);
                                while ($d = mysqli_fetch_assoc($data)) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['PenjualanID']; ?></td>
                                    <td><?php echo $d['TanggalPenjualan']; ?></td>
                                    <td><?php echo $d['NamaProduk']; ?></td>
                                    <td><?php echo $d['PelangganID']; ?></td>
                                    <td><?php echo $d['Jumlah']; ?></td>
                                    <td>Rp. <?php echo number_format($d['TotalHarga'], 0, ',', '.'); ?></td>
                                    <td>
                                    <button class="btn btn-warning btn-sm" onclick="bukaCetakStruk(<?php echo $d['PenjualanID']; ?>)">
                                        <i class="bi bi-printer-fill"></i> Cetak Struk
                                    </button>
                                </td>
                                    <script>
                                    function bukaCetakStruk(id) {
                                        window.open(`struk-selesai.php?PenjualanID=${id}`, 'Struk', 'width=400,height=600');

                                        setTimeout(() => {
                                            window.location.href = 'data-penjualan.php';
                                        }, 2000);
                                    }
                                    </script>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
