<?php
session_start();
include 'koneksi.php';

$pelanggan = $_SESSION['pelanggan'] ?? [
    'PelangganID' => '',
    'NamaPelanggan' => '',
    'Alamat' => '',
    'NomorTelepon' => ''
];


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pelanggan WHERE PelangganID = '$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // Simpan ke session agar tetap ada setelah reload
        $_SESSION['pelanggan'] = $data;
    }

    echo json_encode($data);
    exit;
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    $query = "SELECT * FROM Produk WHERE ProdukID = '$barcode'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        if (isset($_SESSION['keranjang'][$barcode])) {
            $_SESSION['keranjang'][$barcode]['Jumlah']++;
        } else {
            $_SESSION['keranjang'][$barcode] = [
                'ProdukID' => $product['ProdukID'],
                'NamaProduk' => $product['NamaProduk'],
                'Harga' => $product['Harga'],
                'Jumlah' => 1
            ];
        }
    } else {
        header('Location: penjualan.php?pesan=gagal');
        exit;
    }
    header('Location: penjualan.php');
    exit;
}

if (isset($_POST['hapus'])) {
    unset($_SESSION['keranjang']);
    unset($_SESSION['pelanggan']);
    header('Location: ../pages/penjualan.php?pesan=hapus');
    exit;
}

if (isset($_POST['simpan'])) {
    $totalHarga = 0;
    date_default_timezone_set('Asia/Jakarta');
    $tanggalPenjualan = date('Y-m-d H:i:s');
    $idPelanggan = $_POST['searchPelanggan'] ?? '';
    $uangDibayar = isset($_POST['bayar']) ? intval($_POST['bayar']) : 0; // Pastikan nilai di-cast ke integer

    // Validasi apakah semua kolom form sudah terisi
    if (empty($idPelanggan)) {
        echo "<script>
            alert('Kolom ID Pelanggan harus diisi.');
            window.location.href = '../pages/penjualan.php';
        </script>";
        exit;
    }

    if (!is_numeric($uangDibayar) || $uangDibayar <= 0) {
        echo "<script>
            alert('Kolom pembayaran harus diisi dengan nominal yang valid.');
            window.location.href = '../pages/penjualan.php';
        </script>";
        exit;
    }

    // Hitung total harga dari keranjang
    foreach ($_SESSION['keranjang'] as $item) {
        $totalHarga += $item['Harga'] * $item['Jumlah'];
    }

    // Validasi apakah uang yang dibayarkan cukup
    if ($uangDibayar < $totalHarga) {
        echo "<script>
            alert('Nominal uang yang dibayarkan tidak cukup. Harap periksa kembali.');
            window.location.href = '../pages/penjualan.php';
        </script>";
        exit;
    }

    // Jika validasi lolos, lanjutkan proses penyimpanan transaksi
    $queryPenjualan = "INSERT INTO Penjualan (TanggalPenjualan, TotalHarga, PelangganID) VALUES ('$tanggalPenjualan', '$totalHarga', '$idPelanggan')";
    mysqli_query($conn, $queryPenjualan);
    $penjualanId = mysqli_insert_id($conn);

    foreach ($_SESSION['keranjang'] as $item) {
        $produkID = $item['ProdukID'];
        $namaProduk = $item['NamaProduk'];
        $jumlah = $item['Jumlah'];
        $subtotal = $item['Harga'] * $item['Jumlah'];

        $queryDetail = "INSERT INTO DetailPenjualan (PenjualanID, TanggalPenjualan, NamaProduk, Jumlah, TotalHarga) VALUES ('$penjualanId', '$tanggalPenjualan', '$namaProduk', $jumlah, '$subtotal')";
        mysqli_query($conn, $queryDetail);

        $queryUpdateStok = "UPDATE Produk SET Stok = Stok - {$item['Jumlah']} WHERE ProdukID = '$produkID'";
        mysqli_query($conn, $queryUpdateStok);
    }

    unset($_SESSION['keranjang']);
    unset($_SESSION['pelanggan']);
    echo "<script>
        window.open('../pages/struk.php?penjualan_id=$penjualanId', 'Struk', 'width=400,height=600');
        setTimeout(function() {
            window.location.href = '../pages/penjualan.php';
        }, 2000);
    </script>";
    exit;
}
?>
