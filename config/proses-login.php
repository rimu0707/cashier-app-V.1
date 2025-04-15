<?php 
session_start();
include "../config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($conn, "SELECT * From petugas where username='$username' and password='$password'");
$data = mysqli_fetch_assoc($login);

if($data > 0){
    if ($data['level']=="admin") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        header("location: ../pages/dashboard.php");
    }else if ($data['level']=="petugas") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "petugas";
        header( "location: ../pages/dashboard.php");
    }else {
        header('location: ../index.php');
    } 
}else {
    header('location: ../index.php');
}
?>
    