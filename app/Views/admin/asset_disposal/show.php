<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<h1>Detail Permohonan Penghapusan Aset</h1>

<p><strong>ID:</strong> <?= $disposal['id'] ?></p>
<p><strong>Asset ID:</strong> <?= $disposal['asset_id'] ?></p>
<p><strong>Alasan:</strong> <?= $disposal['alasan'] ?></p>
<p><strong>Nilai Residu:</strong> <?= $disposal['nilai_residu'] ?></p>
<p><strong>Metode:</strong> <?= $disposal['metode'] ?></p>
<p><strong>Status:</strong> <?= $disposal['status'] ?></p>
<p><strong>Dokumen Pendukung:</strong> <a
        href="<?= base_url('uploads/dokumen_disposal/' . $disposal['dokumen_pendukung']) ?>">Lihat Dokumen</a></p>

<a href="<?= site_url('admin/asset_disposal') ?>">Kembali ke Daftar Permohonan</a>

<?= $this->endSection(); ?>