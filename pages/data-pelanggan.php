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
            <h5 class="mb-0"><i class="bi bi-box-seam-fill me-2"></i>Manajemen Pelanggan</h5>
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
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../config/koneksi.php';
                        $no = 1;
                        $data = mysqli_query($conn, "SELECT * FROM pelanggan");
                        while ($d = mysqli_fetch_array($data)) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['PelangganID']; ?></td>
                                <td><?php echo $d['NamaPelanggan']; ?></td>
                                <td><?php echo $d['NomorTelepon'];?></td>
                                <td><?php echo $d['Alamat'];?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['PelangganID']; ?>">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['PelangganID']; ?>">Hapus</button>
                                </td>
                            </tr>

                            <!-- Modal Edit Data -->
                            <div class="modal fade" id="edit-data<?php echo $d['PelangganID']; ?>" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../config/proses-pelanggan.php?action=update" method="post">
                                            <div class="modal-body">
                                            <div class="form-group">
                                                    <label>ID</label>
                                                    <input type="text" name="PelangganID" class="form-control" value="<?php echo $d['PelangganID']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Pelanggan</label>
                                                    <input type="text" name="NamaPelanggan" class="form-control" value="<?php echo $d['NamaPelanggan']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Pelanggan</label>
                                                    <input type="text" name="NomorTelepon" class="form-control" value="<?php echo $d['NomorTelepon']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Stok Produk</label>
                                                    <input type="text" name="Alamat" class="form-control" value="<?php echo $d['Alamat']; ?>">
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
                            <div class="modal fade" id="hapus-data<?php echo $d['PelangganID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="../config/proses-pelanggan.php?action=hapus">
                                            <div class="modal-body">
                                                <input type="hidden" name="PelangganID" value="<?php echo $d['PelangganID']; ?>">
                                                Apakah Anda yakin ingin menghapus <b><?php echo $d['NamaPelanggan']; ?></b>?
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
            <form action="../config/proses-pelanggan.php?action=simpan" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ID Pelanggan</label>
                        <input type="text" name="ProdukID" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="NamaPelanggan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="number" name="NomorTelepon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="Alamat" class="form-control" required>
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