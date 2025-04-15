<?php
include 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'hapus') {
    $id_petugas = $_POST['id_petugas'];
    mysqli_query($conn, "DELETE FROM petugas WHERE id_petugas='$id_petugas'");
    header("location: ../../pages/kelola-user.php?pesan=hapus");

} elseif ($action == 'simpan') {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    mysqli_query($conn, "INSERT INTO petugas (nama_petugas, username, password, level) VALUES ('$nama_petugas', '$username', '$password', '$level')");
    header("location: ../../pages/kelola-user.php?pesan=simpan");

} elseif ($action == 'update') {
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    if (!$password) {
        mysqli_query($conn, "UPDATE petugas SET nama_petugas='$nama_petugas', username='$username', level='$level' WHERE id_petugas='$id_petugas'");
    } else {
        mysqli_query($conn, "UPDATE petugas SET nama_petugas='$nama_petugas', username='$username', password='$password', level='$level' WHERE id_petugas='$id_petugas'");
    }
    header("location: ../../pages/kelola-user.php?pesan=update");

} else {

}
?>
