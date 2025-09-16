<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Daftar Aset</h4>
                    <a href="<?= base_url('admin/AssetController/create') ?>" style="margin-left: 50px;"
                        class="btn btn-warning">
                        <i class="fas fa-plus"></i> Tambah Aset Baru
                    </a>

                    <a href="<?= base_url('admin/assets/export') ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Data Aset
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis BMN</th>
                                    <th>Kode Satker</th>
                                    <th>Nama Satker</th>
                                    <th>Kode Barang</th>
                                    <th>NUP</th>
                                    <th>Nama Barang</th>
                                    <th>Merk</th>
                                    <th>Tipe</th>
                                    <th>Kondisi</th>
                                    <th>Umur Aset</th>
                                    <th>Intra / Extra</th>
                                    <th>Tanggal Perolehan</th>
                                    <th>Nilai Perolehan</th>
                                    <th>Nilai Penyusutan</th>
                                    <th>Nilai Buku</th>
                                    <th>Status Penggunaan</th>
                                    <th>No PSP</th>
                                    <th>Tanggal PSP</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assets as $index => $asset): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= esc($asset['jenis_bmn']); ?></td>
                                        <td><?= esc($asset['kode_satker']); ?></td>
                                        <td><?= esc($asset['nama_satker']); ?></td>
                                        <td><?= esc($asset['kode_barang']); ?></td>
                                        <td><?= esc($asset['nup']); ?></td>
                                        <td><?= esc($asset['nama_barang']); ?></td>
                                        <td><?= esc($asset['merk']); ?></td>
                                        <td><?= esc($asset['tipe']); ?></td>
                                        <td><?= esc($asset['kondisi']); ?></td>
                                        <td><?= esc($asset['umur_aset']); ?></td>
                                        <td><?= esc($asset['intra_extra']); ?></td>
                                        <td><?= esc($asset['tanggal_perolehan']); ?></td>
                                        <td><?= esc(number_format($asset['nilai_perolehan'], 0, ',', '.')); ?></td>
                                        <td><?= esc(number_format($asset['nilai_penyusutan'], 0, ',', '.')); ?></td>
                                        <td><?= esc(number_format($asset['nilai_buku'], 0, ',', '.')); ?></td>
                                        <td><?= esc($asset['status_penggunaan']); ?></td>
                                        <td><?= esc($asset['no_psp']); ?></td>
                                        <td><?= esc($asset['tanggal_psp']); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('assets/edit/' . $asset['id']); ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="submit" style="margin-top: 4px;"
                                                class="btn btn-danger btn-sm delete-btn" data-id="<?= $asset['id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('.delete-btn').on('click', function () {
            let assetId = $(this).data('id');

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data aset yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("<?= base_url('assets/delete/'); ?>" + assetId, {
                        _method: "post",
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    })
                        .done(function () {
                            Swal.fire("Terhapus!", "Aset telah dihapus.", "success").then(() => {
                                location.reload();
                            });
                        })
                        .fail(function () {
                            Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus.", "error");
                        });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>