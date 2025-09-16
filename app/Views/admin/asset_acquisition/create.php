<?= $this->extend('templates/admin') ?>

<?= $this->section('page-content') ?>
<meta name="csrf_token" content="<?= csrf_hash(); ?>" />

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Ajukan Akuisisi Aset</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/asset_acquisition/store') ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                        <div class="mb-3">
                            <label class="form-label">Pilih Rencana Aset</label>
                            <select name="plan_id" id="plan_id" class="form-control" required>
                                <option value="">-- Pilih Rencana Aset --</option>
                                <?php foreach ($approvedPlans as $plan): ?>
                                    <option value="<?= $plan['id'] ?>" data-merk="<?= $plan['merk'] ?>"
                                        data-nama="<?= $plan['nama_aset'] ?>" data-biaya="<?= $plan['estimasi_biaya'] ?>"
                                        data-vendor="<?= $plan['vendor'] ?>">
                                        <?= $plan['nama_aset'] ?> (<?= $plan['merk'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Merk Aset</label>
                            <input type="text" id="merk" name="merk" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estimasi Biaya</label>
                            <input type="number" id="estimasi_biaya" name="estimasi_biaya" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <input type="text" id="vendor" name="vendor" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis BMN</label>
                            <input type="text" name="jenis_bmn" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Satker</label>
                            <input type="text" name="kode_satker" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Satker</label>
                            <input type="text" name="nama_satker" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NUP</label>
                            <input type="text" name="nup" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe</label>
                            <input type="text" name="tipe" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Umur Aset (tahun)</label>
                            <input type="number" name="umur_aset" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Intra / Extra</label>
                            <select name="intra_extra" class="form-control">
                                <option value="Intra">Intra</option>
                                <option value="Extra">Extra</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Perolehan</label>
                            <input type="number" name="nilai_perolehan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Penyusutan</label>
                            <input type="number" name="nilai_penyusutan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Buku</label>
                            <input type="number" name="nilai_buku" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Penggunaan</label>
                            <select name="status_penggunaan" class="form-control">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Digunakan">Digunakan</option>
                                <option value="Dihapus">Dihapus</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No PSP</label>
                            <input type="text" name="no_psp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal PSP</label>
                            <input type="date" name="tanggal_psp" class="form-control" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Ajukan</button>
                            <a href="<?= base_url('admin/asset_acquisition') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('plan_id').addEventListener('change', function () {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('merk').value = selectedOption.getAttribute('data-merk');
        document.getElementById('nama_barang').value = selectedOption.getAttribute('data-nama');
        document.getElementById('estimasi_biaya').value = selectedOption.getAttribute('data-biaya');
        document.getElementById('vendor').value = selectedOption.getAttribute('data-vendor');
    });
</script>

<?= $this->endSection() ?>