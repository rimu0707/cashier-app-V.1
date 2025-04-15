<?php
session_start();
include '../config/koneksi.php';
include '../config/proses-kelola-user.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Kelola Data Petugas</h5>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">
                Tambah Data
            </button>
        </div>
        <div class="card-body">
            <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "simpan") { ?>
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Disimpan
                    </div>
                <?php }
                if ($_GET['pesan'] == "update") { ?>
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Diupdate
                    </div>
                <?php }
                if ($_GET['pesan'] == "hapus") { ?>
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Dihapus
                    </div>
                <?php }
            }
            ?>
         <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table">
                    <tr>
                        <th>No</th>
                        <th>Nama Petugas</th>
                        <th>Username</th>
                        <th>Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../config/koneksi.php';
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM petugas");
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['nama_petugas']; ?></td>
                            <td><?php echo $d['username']; ?></td>
                            <td>
                                <?php echo $d['level'] == 'admin' ? 'Administrator' : 'Petugas'; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['id_petugas']; ?>">
                                    Edit
                                </button>
                                <?php if ($d['level'] != $_SESSION['level']) { ?>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['id_petugas']; ?>">
                                        Hapus
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>

                        <!-- Modal Edit Data -->
                        <div class="modal fade" id="edit-data<?php echo $d['id_petugas']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editModalLabel">Edit Data Petugas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../config/proses-kelola-user.php?action=update" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_petugas" value="<?php echo $d['id_petugas']; ?>">
                                            <div class="mb-3">
                                                <label for="namaPetugas" class="form-label">Nama Petugas</label>
                                                <input type="text" class="form-control" id="namaPetugas" name="nama_petugas" value="<?php echo $d['nama_petugas']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $d['username']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
                                            </div>
                                            <div class="mb-3">
                                                <label for="level" class="form-label">Akses</label>
                                                <select class="form-select" id="level" name="level" required>
                                                    <option value="1" <?php echo $d['level'] == 'admin' ? 'selected' : ''; ?>>Administrator</option>
                                                    <option value="2" <?php echo $d['level'] == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus Data -->
                        <div class="modal fade" id="hapus-data<?php echo $d['id_petugas']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="hapusModalLabel">Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../config/proses-kelola-user.php?action=hapus" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_petugas" value="<?php echo $d['id_petugas']; ?>">
                                            <p>Apakah Anda yakin ingin menghapus data <b><?php echo $d['nama_petugas']; ?></b>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
<div class="modal fade" id="tambah-data" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../config/proses-kelola-user.php?action=simpan" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namaPetugas" class="form-label">Nama Petugas</label>
                        <input type="text" class="form-control" id="namaPetugas" name="nama_petugas" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Akses</label>
                        <select class="form-select" id="level" name="level" required>
                            <option value="1">Administrator</option>
                            <option value="2">Petugas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>