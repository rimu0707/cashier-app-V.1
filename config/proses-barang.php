<?php
include '../config/koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'simpan') {
    $ProdukID = $_POST['ProdukID'];
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];

    mysqli_query($conn, "INSERT INTO produk (ProdukID, NamaProduk, Harga, Stok) VALUES ('$ProdukID', '$NamaProduk', '$Harga', '$Stok')");
    header("location: ../../pages/data-barang.php?pesan=simpan");

} elseif ($action == 'update') {
    $ProdukID = $_POST['ProdukID'];
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];

    mysqli_query($conn, "UPDATE produk SET NamaProduk='$NamaProduk', Harga='$Harga', Stok='$Stok' WHERE ProdukID='$ProdukID'");
    header("location: ../../pages/data-barang.php?pesan=update");

} elseif ($action == 'hapus') {
    $ProdukID = $_POST['ProdukID'];

    mysqli_query($conn, "DELETE FROM produk WHERE ProdukID='$ProdukID'");
    header("location: ../../pages/data-barang.php?pesan=hapus");
} else {
    header("location: ../../pages/data-barang.php?pesan=aksi_tidak_dikenali");
}
?>