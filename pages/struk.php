<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
include '../config/koneksi.php';

// Ambil PenjualanID terakhir
$queryLastPenjualan = "SELECT * FROM Penjualan ORDER BY PenjualanID DESC LIMIT 1";
$resultLastPenjualan = mysqli_query($conn, $queryLastPenjualan);
$penjualan = mysqli_fetch_assoc($resultLastPenjualan);

if (!$penjualan) {
    echo "Tidak ada transaksi terbaru.";
    exit;
}

$penjualanId = $penjualan['PenjualanID'];
$tanggalPenjualan = $penjualan['TanggalPenjualan'];
$totalHarga = $penjualan['TotalHarga'];
$pelangganId = $penjualan['PelangganID']; // Tambahkan PelangganID

// Ambil detail transaksi dengan harga produk dari tabel Produk
$queryDetail = "
    SELECT dp.NamaProduk, dp.Jumlah, p.Harga, (dp.Jumlah * p.Harga) AS TotalHarga
    FROM DetailPenjualan dp
    JOIN Produk p ON dp.NamaProduk = p.NamaProduk
    WHERE dp.PenjualanID = '$penjualanId'
";

$resultDetail = mysqli_query($conn, $queryDetail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/struk.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
</head>
<body>
    <div class="struk">
        <div class="header">
            <p>Lapo Rutma</p>
            <p>Jl. Kalimalang Pinggir Kali</p>
            <p>Bekasi, Jawa Barat</p>
            <hr>
            <p><?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i'); ?></p>
            <p>Kasir: <?php echo $_SESSION['username']; ?></p>
            <?php if ($pelangganId): ?>
                <p>ID Pelanggan: <?php echo $pelangganId; ?></p>
            <?php endif; ?>
        </div>
        <table>
            <tr>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($resultDetail)) {
                echo "<tr>";
                echo "<td>{$row['NamaProduk']}</td>";
                echo "<td>{$row['Jumlah']}</td>";
                echo "<td>Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>";
                echo "<td>Rp " . number_format($row['TotalHarga'], 0, ',', '.') . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <hr>
        <p class="total"><strong>Total: Rp <?php echo number_format($totalHarga, 0, ',', '.'); ?></strong></p>
        <p class="footer">
            Terima kasih, Selamat Belanja Kembali!<br>
            Layanan Konsumen<br>
            SMS/CALL: 0866-6666-6666
        </p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
