<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<meta name="csrf_token" content="<?= csrf_hash(); ?>" />

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Rencana Aset</h4>
                </div>
                <div class="card-body">
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/asset-plan/update/<?= $plan['id'] ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <div class="mb-3">
                            <label for="nama_aset" class="form-label">Nama Aset</label>
                            <input type="text" name="nama_aset" id="nama_aset" class="form-control"
                                value="<?= $plan['nama_aset'] ?>" required placeholder="Masukkan nama aset">
                        </div>

                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk Aset</label>
                            <input type="text" name="merk" id="merk" class="form-control"
                                value="<?= $plan['merk'] ?>" required placeholder="Masukkan jenis aset">
                        </div>

                        <div class="mb-3">
                            <label for="estimasi_biaya" class="form-label">Estimasi Biaya</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="estimasi_biaya" id="estimasi_biaya" class="form-control"
                                    value="<?= $plan['estimasi_biaya'] ?>" step="0.01" required
                                    placeholder="Masukkan estimasi biaya">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="vendor" class="form-label">Vendor</label>
                            <textarea name="vendor" id="vendor" rows="3" class="form-control" required
                                placeholder="Masukkan vendor"><?= $plan['vendor'] ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_risiko" class="form-label">Kategori Risiko</label>
                            <select name="kategori_risiko" id="kategori_risiko" class="form-control" required>
                                <option value="Rendah" <?= $plan['kategori_risiko'] == 'Rendah' ? 'selected' : '' ?>>Rendah
                                </option>
                                <option value="Sedang" <?= $plan['kategori_risiko'] == 'Sedang' ? 'selected' : '' ?>>Sedang
                                </option>
                                <option value="Tinggi" <?= $plan['kategori_risiko'] == 'Tinggi' ? 'selected' : '' ?>>Tinggi
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_risiko" class="form-label">Deskripsi Resiko</label>
                            <textarea name="deskripsi_risiko" id="deskripsi_risiko" rows="3" class="form-control" required
                                placeholder="Masukkan deskripsi_risiko"><?= $plan['deskripsi_risiko'] ?></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="/admin/asset-plan" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>