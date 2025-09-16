<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <div class="main-card mt-4 card">
        <div class="container mt-4">
            <h1>Edit Laporan</h1>
            <form action="<?= base_url('PostController/update'); ?>" method="post" class="form-container">
                <div class="container-fluid bg-transparent p-2 rounded" id="box">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $laporan['id']; ?>">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama:</label>
                                <input type="text" class="form-control" name="nama" value="<?= $laporan['nama']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="nomor_aset" class="form-label">Nomor Aset:</label>
                                <input type="text" class="form-control" name="nomor_aset"
                                    value="<?= $laporan['nomor_aset']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="jenis_aset" class="form-label">Jenis Aset:</label>
                                <input type="text" class="form-control" name="jenis_aset"
                                    value="<?= $laporan['jenis_aset']; ?>" required>
                            </div>



                            <div class="form-group">
                                <label for="kondisi_aset" class="form-label">Kondisi Aset:</label>
                                <select class="form-control" name="kondisi_aset" required>
                                    <option value="Bagus" <?= ($laporan['kondisi_aset'] == 'Bagus') ? 'selected' : ''; ?>>
                                        Bagus</option>
                                    <option value="Rusak Ringan" <?= ($laporan['kondisi_aset'] == 'Rusak Ringan') ? 'selected' : ''; ?>>Rusak Ringan</option>
                                    <option value="Rusak Berat" <?= ($laporan['kondisi_aset'] == 'Rusak Berat') ? 'selected' : ''; ?>>Rusak Berat</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi:</label>
                                <textarea class="form-control" name="deskripsi"
                                    required><?= $laporan['deskripsi']; ?></textarea>
                            </div>


                        </div>

                        <div class="col-md-6">


                            <div class="form-group">
                                <label for="lokasi" class="form-label">Lokasi:</label>
                                <input type="text" class="form-control" name="lokasi" value="<?= $laporan['lokasi']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="created_at" class="form-label">Tanggal Pembuatan Laporan:</label>
                                <input type="text" class="form-control" name="created_at"
                                    value="<?= $laporan['created_at']; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-control" name="status" required>
                                    <option value="Dalam Proses" <?= ($laporan['status'] == 'Dalam Proses') ? 'selected' : ''; ?>>Dalam Proses</option>
                                    <option value="Selesai" <?= ($laporan['status'] == 'Selesai') ? 'selected' : ''; ?>>
                                        Selesai</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai Laporan:</label>
                                <input type="datetime-local" class="form-control" name="tanggal_selesai"
                                    value="<?= isset($laporan['tanggal_selesai']) && $laporan['status'] == 'Selesai' ? date('Y-m-d\TH:i:s', strtotime($laporan['tanggal_selesai'])) : ''; ?>"
                                    <?= ($laporan['status'] != 'Selesai') ? 'disabled' : ''; ?> step="1">
                            </div>



                        </div>

                        <div class="col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>