<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <h2 class="mb-4">Ajukan Permohonan Penghapusan Aset</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Terjadi Kesalahan!",
                    html: `<ul class="text-danger">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>`,
                    icon: "error"
                });
            });
        </script>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <form action="<?= site_url('admin/asset_disposal/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="asset_id" class="form-label">Pilih Aset:</label>
                    <select name="asset_id" id="asset_id" class="form-select" required>
                        <option value="">-- Pilih Aset --</option>
                        <?php foreach ($assets as $asset): ?>
                            <option value="<?= $asset['id'] ?>" data-kode="<?= $asset['kode_barang'] ?>"
                                data-nup="<?= $asset['nup'] ?>" data-merk="<?= $asset['merk'] ?>">
                                <?= $asset['kode_barang'] ?> | <?= $asset['nup'] ?> - <?= esc($asset['nama_barang']) ?>
                                (<?= $asset['merk'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Kode Barang:</label>
                        <input type="text" id="kode_barang" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NUP:</label>
                        <input type="text" id="nup" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Merk:</label>
                        <input type="text" id="merk" class="form-control" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Penghapusan:</label>
                    <textarea name="alasan" id="alasan" class="form-control" required><?= old('alasan') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="nilai_residu" class="form-label">Nilai Residu (Rp):</label>
                    <input type="number" step="0.01" name="nilai_residu" id="nilai_residu" class="form-control" required
                        value="<?= old('nilai_residu') ?>">
                </div>

                <div class="mb-3">
                    <label for="metode" class="form-label">Metode Penghapusan:</label>
                    <select name="metode" id="metode" class="form-control" required>
                        <option value="Jual">Jual</option>
                        <option value="Hibah">Hibah</option>
                        <option value="Daur Ulang">Daur Ulang</option>
                        <option value="Musnahkan">Musnahkan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung (PDF):</label>
                    <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" class="form-control"
                        accept=".pdf" required>
                    <small id="file-chosen" class="text-muted">Belum ada file dipilih</small>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Ajukan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("asset_id").addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex];

        document.getElementById("kode_barang").value = selectedOption.getAttribute("data-kode") || "-";
        document.getElementById("nup").value = selectedOption.getAttribute("data-nup") || "-";
        document.getElementById("merk").value = selectedOption.getAttribute("data-merk") || "-";
    });

    document.getElementById("dokumen_pendukung").addEventListener("change", function () {
        document.getElementById("file-chosen").textContent = this.files[0] ? this.files[0].name : "Belum ada file dipilih";
    });
</script>

<?= $this->endSection(); ?>