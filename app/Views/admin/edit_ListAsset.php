<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Aset</h4>
                </div>
                <div class="card-body">
                    <form id="editAssetForm" action="<?= base_url('assets/update/' . $asset['id']); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis BMN</label>
                                    <input type="text" name="jenis_bmn" class="form-control"
                                        value="<?= esc($asset['jenis_bmn']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Kode Satker</label>
                                    <input type="text" name="kode_satker" class="form-control"
                                        value="<?= esc($asset['kode_satker']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Satker</label>
                                    <input type="text" name="nama_satker" class="form-control"
                                        value="<?= esc($asset['nama_satker']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <input type="text" name="kode_barang" class="form-control"
                                        value="<?= esc($asset['kode_barang']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>NUP</label>
                                    <input type="text" name="nup" class="form-control"
                                        value="<?= esc($asset['nup']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control"
                                        value="<?= esc($asset['nama_barang']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Merk</label>
                                    <input type="text" name="merk" class="form-control"
                                        value="<?= esc($asset['merk']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <input type="text" name="tipe" class="form-control"
                                        value="<?= esc($asset['tipe']); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kondisi</label>
                                    <select name="kondisi" class="form-control">
                                        <option value="Baik" <?= ($asset['kondisi'] == 'Baik') ? 'selected' : ''; ?>>Baik
                                        </option>
                                        <option value="Rusak Ringan" <?= ($asset['kondisi'] == 'Rusak Ringan') ? 'selected' : ''; ?>>Rusak Ringan</option>
                                        <option value="Rusak Berat" <?= ($asset['kondisi'] == 'Rusak Berat') ? 'selected' : ''; ?>>Rusak Berat</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Umur Aset</label>
                                    <input type="number" name="umur_aset" class="form-control"
                                        value="<?= esc($asset['umur_aset']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Intra / Extra</label>
                                    <select name="intra_extra" class="form-control">
                                        <option value="Intra" <?= ($asset['intra_extra'] == 'Intra') ? 'selected' : ''; ?>>
                                            Intra</option>
                                        <option value="Extra" <?= ($asset['intra_extra'] == 'Extra') ? 'selected' : ''; ?>>
                                            Extra</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Perolehan</label>
                                    <input type="date" name="tanggal_perolehan" class="form-control"
                                        value="<?= esc($asset['tanggal_perolehan']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Nilai Perolehan</label>
                                    <input type="number" name="nilai_perolehan" class="form-control"
                                        value="<?= esc($asset['nilai_perolehan']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Status Penggunaan</label>
                                    <select name="status_penggunaan" class="form-control">
                                        <option value="Digunakan" <?= ($asset['status_penggunaan'] == 'Digunakan') ? 'selected' : ''; ?>>Digunakan</option>
                                        <option value="Tidak Digunakan" <?= ($asset['status_penggunaan'] == 'Tidak Digunakan') ? 'selected' : ''; ?>>Tidak Digunakan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No PSP</label>
                                    <input type="text" name="no_psp" class="form-control"
                                        value="<?= esc($asset['no_psp']); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal PSP</label>
                                    <input type="date" name="tanggal_psp" class="form-control"
                                        value="<?= esc($asset['tanggal_psp']); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="<?= base_url('assets'); ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#editAssetForm').on('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Konfirmasi",
                text: "Yakin ingin menyimpan perubahan?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>