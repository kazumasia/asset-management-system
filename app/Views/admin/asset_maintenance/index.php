<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<?php
use Myth\Auth\Authorization\GroupModel;

$groupModel = new GroupModel();
$userGroups = $groupModel->getGroupsForUser(user_id());

$groupNames = array_column($userGroups, 'name');

$userRole = !empty($groupNames) ? implode(',', $groupNames) : 'user';

?>
<meta name="user-role" content="<?= esc($userRole); ?>">
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Daftar Pemeliharaan Aset</h2>
            <a href="<?= base_url('/admin/asset_maintenance/create') ?>"
                class="btn btn-primary pemeliharaan-btn mb-3">Tambah
                Pemeliharaan</a>

            <a href="<?= base_url('admin/asset_maintenance/export'); ?>" class="btn btn-success mb-3">
                <i class="fas fa-file-excel"></i> Export Semua
            </a>



            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode Aset</th>
                                    <th>NUP</th>
                                    <th>Nama Aset</th>
                                    <th>Merk</th>
                                    <th>Teknisi</th>
                                    <th>Jadwal</th>
                                    <th>Biaya</th>
                                    <th>Status</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($maintenance as $m): ?>
                                    <tr>
                                        <td><?= esc($m['kode_barang']) ?></td>
                                        <td><?= esc($m['nup'] ?: '-') ?></td>
                                        <td><?= esc($m['nama_barang']) ?></td>
                                        <td><?= esc($m['merk']) ?></td>
                                        <td><?= esc($m['teknisi']) ?></td>
                                        <td><?= esc($m['jadwal_pemeliharaan']) ?></td>
                                        <td>Rp <?= number_format($m['biaya'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php
                                            $statusClass = 'badge-primary';
                                            if ($m['status'] == 'Selesai') {
                                                $statusClass = 'badge-success';
                                            } elseif ($m['status'] == 'Dalam Proses') {
                                                $statusClass = 'badge-warning';
                                            }
                                            ?>
                                            <button class="btn btn-sm ubah-status-btn <?= $statusClass ?>"
                                                data-id="<?= $m['id'] ?>" data-status="<?= $m['status'] ?>">
                                                <?= esc($m['status']) ?>
                                            </button>
                                        </td>

                                        <td>
                                            <?= ($m['status'] == 'Selesai' && $m['updated_at']) ? esc($m['updated_at']) : '<span class="text-danger fw-bold">(Belum Selesai)</span>' ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm hapus-btn"
                                                data-id="<?= $m['id'] ?>">Hapus</button>
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
        // Ubah status dengan SweetAlert modal
        $(".ubah-status-btn").click(function () {
            let maintenanceId = $(this).data("id");
            let currentStatus = $(this).data("status");

            Swal.fire({
                title: "Ubah Status Pemeliharaan",
                text: "Pilih status baru:",
                icon: "question",
                showCancelButton: true,
                showDenyButton: true,
                showConfirmButton: true,
                confirmButtonText: "Selesai",
                denyButtonText: "Dalam Proses",
                cancelButtonText: "Dijadwalkan",
                confirmButtonColor: "#28a745",
                denyButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d"
            }).then((result) => {
                let newStatus = null;
                if (result.isConfirmed) {
                    newStatus = "Selesai";
                } else if (result.isDenied) {
                    newStatus = "Dalam Proses";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    newStatus = "Dijadwalkan";
                }

                if (newStatus && newStatus !== currentStatus) {
                    $.ajax({
                        url: "<?= base_url('admin/asset_maintenance/updateStatus/') ?>" + maintenanceId,
                        type: "POST",
                        data: { status: newStatus, "<?= csrf_token() ?>": "<?= csrf_hash() ?>" },
                        success: function (response) {
                            Swal.fire("Berhasil!", "Status diperbarui ke: " + newStatus, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire("Error!", "Gagal memperbarui status.", "error");
                        }
                    });
                }
            });
        });

        // Hapus dengan SweetAlert modal
        $(".hapus-btn").click(function () {
            let maintenanceId = $(this).data("id");

            Swal.fire({
                title: "Hapus Pemeliharaan?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin/asset_maintenance/delete/') ?>" + maintenanceId,
                        type: "POST",
                        data: { "<?= csrf_token() ?>": "<?= csrf_hash() ?>" },
                        success: function (response) {
                            Swal.fire("Terhapus!", "Data berhasil dihapus.", "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            let errorMessage = "Terjadi kesalahan.";
                            if (xhr.status === 403) {
                                errorMessage = "Akses ditolak! (403 Forbidden)";
                            } else if (xhr.status === 404) {
                                errorMessage = "Data tidak ditemukan!";
                            }
                            Swal.fire("Error!", errorMessage, "error");
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let userRoles = userRole.toLowerCase().split(",");

        if (!userRoles.includes("ipds")) {
            $(document).on("click", ".ubah-status-btn, .edit-btn, .selesai-btn, .hapus-btn, .pemeliharaan-btn, .btn-create-usage, .btn-create-maintenance", function (event) {
                event.preventDefault();
                event.stopImmediatePropagation(); // 🔹 Mencegah event tetap berjalan
                Swal.fire("Akses Ditolak!", "Hanya IPDS yang dapat Menambah, Mengedit, Menghapus dan Mengubah Status Pemeliharaan Aset.", "error");
            });
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        //incase kalo mau ditambahin fitur pencarian
        const searchInput = document.getElementById('search');
        const monthInput = document.getElementById('month');
        const yearInput = document.getElementById('year');
        const exportLink = document.getElementById('exportLink');

        if (searchInput && monthInput && yearInput && exportLink) {
            searchInput.addEventListener('input', updateExportLink);
            monthInput.addEventListener('change', updateExportLink);
            yearInput.addEventListener('change', updateExportLink);

            function updateExportLink() {
                const search = searchInput.value;
                const month = monthInput.value;
                const year = yearInput.value;

                let url = "<?= base_url('admin/asset_maintenance/export'); ?>";
                const params = new URLSearchParams();

                if (search) params.append('search', search);
                if (month) params.append('month', month);
                if (year) params.append('year', year);

                exportLink.href = `${url}?${params.toString()}`;
            }

            updateExportLink();
        }
    });
</script>

<?= $this->endSection(); ?>