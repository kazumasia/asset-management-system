<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Pemeliharaan Aset</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/asset_maintenance/store') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Pilih Aset atau Pengaduan:</label>
                            <select name="asset_id" id="assetSelect" class="form-control" required>
                                <option value="">-- Pilih Aset atau Pengaduan --</option>
                                <?php foreach ($assets as $a): ?>
                                    <?php
                                    $jumlahPengaduan = isset($pengaduan) && is_array($pengaduan) ? count(array_filter($pengaduan, function ($p) use ($a) {
                                        return isset($p['kode_barang'], $p['nup']) &&
                                            $p['kode_barang'] === $a['kode_barang'] &&
                                            $p['nup'] === $a['nup'] &&
                                            $p['status'] !== 'Selesai';
                                    })) : 0;
                                    ?>
                                    <option value="<?= esc($a['id']) ?>" data-kode="<?= esc($a['kode_barang']) ?>"
                                        data-nup="<?= esc($a['nup']) ?>" data-kondisi="<?= esc($a['kondisi_barang']) ?>"
                                        data-deskripsi="<?= esc($a['deskripsi_pengaduan']) ?>"
                                        data-pengaduan="<?= esc($a['pengaduan_id']) ?>">

                                        <?= esc($a['kode_barang']) ?> / NUP: <?= esc($a['nup'] ?: 'Tidak Ada') ?> -
                                        <?= esc($a['nama_barang']) ?>
                                        (<?= esc($a['merk']) ?>)
                                        <?= ($jumlahPengaduan > 0) ? "[{$jumlahPengaduan} Keluhan]" : "[Tanpa Keluhan]" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>


                        </div>

                        <input type="hidden" id="pengaduan_id" name="pengaduan_id" value="">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kondisi Barang:</label>
                                <input type="text" id="kondisiBarang" class="form-control" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Deskripsi Keluhan:</label>
                                <textarea id="deskripsiKeluhan" class="form-control" readonly></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jadwal Pemeliharaan:</label>
                                <input type="date" name="jadwal_pemeliharaan" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teknisi:</label>
                                <input type="text" name="teknisi" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Biaya:</label>
                            <input type="number" name="biaya" class="form-control" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('/admin/asset_maintenance') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("assetSelect").addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex];

        let pengaduanId = selectedOption.getAttribute("data-pengaduan");
        document.getElementById("pengaduan_id").value = pengaduanId;

        document.getElementById("kondisiBarang").value = selectedOption.getAttribute("data-kondisi") || "Tidak diketahui";
        document.getElementById("deskripsiKeluhan").value = selectedOption.getAttribute("data-deskripsi") || "Tidak ada keluhan";
    });
</script>

<?= $this->endSection(); ?>