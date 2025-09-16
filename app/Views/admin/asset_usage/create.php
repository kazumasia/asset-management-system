<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">Tambah Penggunaan Aset</h2>

            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= base_url('admin/asset_usage/store') ?>" method="POST">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="asset_id" class="form-label">Pilih Aset</label>
                            <select class="form-control" name="asset_id" id="asset_id" required>
                                <option value="">-- Pilih Aset --</option>
                                <?php foreach ($assets as $asset): ?>
                                    <option value="<?= $asset['id']; ?>">
                                        <?= $asset['kode_barang']; ?> | <?= $asset['nup']; ?> |
                                        <?= $asset['nama_barang']; ?> | <?= $asset['merk']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>



                        <div class="mb-3">
                            <label for="pegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" name="pegawai" id="pegawai" required>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Penggunaan</label>
                            <textarea class="form-control" name="tujuan" id="tujuan" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai (opsional) </label>
                            <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="Digunakan">Digunakan</option>
                                <option value="Dikembalikan">Dikembalikan</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Penggunaan</button>
                        <a href="<?= base_url('admin/asset_usage') ?>" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>