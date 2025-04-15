<?php
include 'koneksi.php';

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "SELECT * FROM detailpenjualan ORDER BY DetailID DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$dataDetailPenjualan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataDetailPenjualan[] = $row;
}

mysqli_close($conn);
?>
