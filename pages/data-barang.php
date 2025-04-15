<?php 
session_start();
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan</title>
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
            <h5 class="mb-0"><i class="bi bi-box-seam-fill me-2"></i>Manajemen Produk</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">Tambah Data</button>
        </div>
        <div class="card-body">
            <?php
            if (isset($_GET['pesan'])) {
                $alertType = "success";
                $message = "";
                if ($_GET['pesan'] == "simpan") {
                    $message = "Data berhasil disimpan.";
                } elseif ($_GET['pesan'] == "update") {
                    $message = "Data berhasil diperbarui.";
                } elseif ($_GET['pesan'] == "hapus") {
                    $message = "Data berhasil dihapus.";
                }
                if ($message) {
                    echo "<div class='alert alert-$alertType' role='alert'>$message</div>";
                }
            }
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table" style="background-color: #e3f2fd;">
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../config/koneksi.php';
                        $no = 1;
                        $data = mysqli_query($conn, "SELECT * FROM produk");
                        while ($d = mysqli_fetch_array($data)) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['ProdukID']; ?></td>
                                <td><?php echo $d['NamaProduk']; ?></td>
                                <td>Rp. <?php echo number_format($d['Harga'], 0, ',', '.'); ?></td>
                                <td><?php echo $d['Stok']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['ProdukID']; ?>">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['ProdukID']; ?>">Hapus</button>
                                </td>
                            </tr>

                            <!-- Modal Edit Data -->
                            <div class="modal fade" id="edit-data<?php echo $d['ProdukID']; ?>" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../config/proses-barang.php?action=update" method="post">
                                            <div class="modal-body">
                                            <div class="form-group">
                                                    <label>Barcode</label>
                                                    <input type="text" name="ProdukID" class="form-control" value="<?php echo $d['ProdukID']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Produk</label>
                                                    <input type="text" name="NamaProduk" class="form-control" value="<?php echo $d['NamaProduk']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Harga Produk</label>
                                                    <input type="number" name="Harga" class="form-control" value="<?php echo $d['Harga']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Stok Produk</label>
                                                    <input type="number" name="Stok" class="form-control" value="<?php echo $d['Stok']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Data -->
                            <div class="modal fade" id="hapus-data<?php echo $d['ProdukID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="../config/proses-barang.php?action=hapus">
                                            <div class="modal-body">
                                                <input type="hidden" name="ProdukID" value="<?php echo $d['ProdukID']; ?>">
                                                Apakah Anda yakin ingin menghapus <b><?php echo $d['NamaProduk']; ?></b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambah-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../config/proses-barang.php?action=simpan" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ID Barang</label>
                        <input type="text" name="ProdukID" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="NamaProduk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Produk</label>
                        <input type="number" name="Harga" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Produk</label>
                        <input type="number" name="Stok" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</html>