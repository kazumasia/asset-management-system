<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Edit Penggunaan Aset</h4>
                </div>
                <div class="card-body">
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('errors') as $error): ?>
                                <p><?= esc($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/asset_usage/update/' . $usage['id']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                value="<?= esc($usage['kode_barang']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nup" class="form-label">NUP</label>
                            <input type="text" class="form-control" id="nup" name="nup"
                                value="<?= esc($usage['nup']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Aset</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                value="<?= esc($usage['nama_barang']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="pegawai" class="form-label">Pegawai</label>
                            <input type="text" class="form-control" id="pegawai" name="pegawai"
                                value="<?= esc($usage['pegawai']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Penggunaan</label>
                            <textarea class="form-control" id="tujuan" name="tujuan" rows="3"
                                required><?= esc($usage['tujuan']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                value="<?= esc($usage['tanggal_mulai']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Penggunaan</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Digunakan" <?= ($usage['status'] == 'Digunakan') ? 'selected' : '' ?>>
                                    Digunakan</option>
                                <option value="Dikembalikan" <?= ($usage['status'] == 'Dikembalikan') ? 'selected' : '' ?>>
                                    Dikembalikan</option>
                                <option value="Rusak" <?= ($usage['status'] == 'Rusak') ? 'selected' : '' ?>>Rusak</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/asset_usage') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>