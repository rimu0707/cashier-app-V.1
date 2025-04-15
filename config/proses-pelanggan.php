<?php
include '../config/koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'simpan') {
    $PelangganID = $_POST['PelangganID'];
    $NamaPelanggan = $_POST['NamaPelanggan'];
    $telepon = $_POST['NomorTelepon'];
    $alamat = $_POST['Alamat'];

    mysqli_query($conn, "INSERT INTO pelanggan (PelangganID, NamaPelanggan, NomorTelepon, Alamat) VALUES ('$PelangganID', '$NamaPelanggan', '$telepon', '$alamat')");
    header("location: ../../pages/data-pelanggan.php?pesan=simpan");

} elseif ($action == 'update') {
    $PelangganID = $_POST['PelangganID'];
    $NamaPelanggan = $_POST['NamaPelanggan'];
    $telepon = $_POST['NomorTelepon'];
    $alamat = $_POST['Alamat'];

    mysqli_query($conn, "UPDATE pelanggan SET NamaPelanggan='$NamaPelanggan', NomorTelepon='$telepon', Alamat='$alamat' WHERE PelangganID='$PelangganID'");
    header("location: ../../pages/data-pelanggan.php?pesan=update");

} elseif ($action == 'hapus') {
    $ProdukID = $_POST['ProdukID'];

    mysqli_query($conn, "DELETE FROM pelanggan WHERE PelangganID='$PelanggaID'");
    header("location: location: ../../pages/data-pelanggan.php?pesan=hapus");
} else {
    header("location: location: ../../pages/data-pelanggan.php?pesan=aksi_tidak_dikenali");
}
?>