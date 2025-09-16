<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Aset Baru</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('assets/store'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-cube"></i> Jenis BMN</label>
                                    <input type="text" name="jenis_bmn" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-building"></i> Kode Satker</label>
                                    <input type="text" name="kode_satker" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-university"></i> Nama Satker</label>
                                    <input type="text" name="nama_satker" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-barcode"></i> Kode Barang</label>
                                    <input type="text" name="kode_barang" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-hashtag"></i> NUP</label>
                                    <input type="text" name="nup" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-box"></i> Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-tag"></i> Merk</label>
                                    <input type="text" name="merk" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-info-circle"></i> Tipe</label>
                                    <input type="text" name="tipe" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-check-circle"></i> Kondisi</label>
                                    <select name="kondisi" class="form-control">
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-exchange-alt"></i> Intra / Extra</label>
                                    <select name="intra_extra" class="form-control">
                                        <option value="Intra">Intra</option>
                                        <option value="Extra">Extra</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-calendar-alt"></i> Tanggal Perolehan</label>
                                    <input type="date" name="tanggal_perolehan" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-dollar-sign"></i> Nilai Perolehan</label>
                                    <input type="text" name="nilai_perolehan" class="form-control currency">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-hand-holding-usd"></i> Nilai Penyusutan</label>
                                    <input type="text" name="nilai_penyusutan" class="form-control currency">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-wallet"></i> Nilai Buku</label>
                                    <input type="text" name="nilai_buku" class="form-control currency">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-tasks"></i> Status Penggunaan</label>
                                    <select name="status_penggunaan" class="form-control">
                                        <option value="Digunakan">Digunakan</option>
                                        <option value="Tidak Digunakan">Tidak Digunakan</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-file-alt"></i> No PSP</label>
                                    <input type="text" name="no_psp" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-calendar-day"></i> Tanggal PSP</label>
                                    <input type="date" name="tanggal_psp" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label><i class="fas fa-clock"></i> Umur Aset</label>
                                    <input type="number" name="umur_aset" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="<?= base_url('admin/assets'); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>