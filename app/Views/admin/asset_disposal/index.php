<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<meta name="csrf-token" content="<?= csrf_hash(); ?>">
<?php
use Myth\Auth\Authorization\GroupModel;

$groupModel = new GroupModel();
$userGroups = $groupModel->getGroupsForUser(user_id());

$groupNames = array_column($userGroups, 'name');

$userRole = !empty($groupNames) ? implode(',', $groupNames) : 'user';

?>
<meta name="user-role" content="<?= esc($userRole); ?>">
<div class="container-fluid mt-4">
    <h2 class="mb-4">Daftar Permohonan Penghapusan Aset</h2>

    <div class="mb-3">
        <a href="<?= base_url('admin/asset_disposal/create') ?>" class="btn btn-primary btn-create-disposal">Buat
            Permohonan</a>
        <a href="<?= base_url('admin/asset_disposal/export') ?>" class="btn btn-success">
            Export Semua
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>NUP</th>
                            <th>Nama Aset</th>
                            <th>Merk</th>
                            <th>Alasan</th>
                            <th>Nilai Residu</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($disposals as $disposal): ?>
                            <tr>
                                <td><?= esc($disposal['id']) ?></td>
                                <td><?= esc($disposal['kode_barang'] ?? '-') ?></td>
                                <td><?= esc($disposal['nup'] ?? '-') ?></td>
                                <td><?= esc($disposal['nama_barang'] ?? 'Tidak Diketahui') ?></td>
                                <td><?= esc($disposal['merk'] ?? '-') ?></td>
                                <td><?= esc($disposal['alasan']) ?></td>
                                <td>Rp<?= number_format($disposal['nilai_residu'], 0, ',', '.') ?></td>
                                <td><?= esc($disposal['metode']) ?></td>
                                <td>
                                    <?php if ($disposal['status'] === 'Menunggu Persetujuan'): ?>
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    <?php elseif ($disposal['status'] === 'Disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d-m-Y', strtotime($disposal['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm detail-btn" data-id="<?= $disposal['id'] ?>">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <?php if ($disposal['status'] === 'Menunggu Persetujuan'): ?>
                                        <button class="btn btn-success btn-sm approve-btn"
                                            data-id="<?= $disposal['id'] ?>">Setujui</button>
                                        <button class="btn btn-danger btn-sm reject-btn"
                                            data-id="<?= $disposal['id'] ?>">Tolak</button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Sudah Diproses</button>
                                    <?php endif; ?>
                                    <button class="btn btn-danger btn-sm hapus-btn"
                                        data-id="<?= $disposal['id'] ?>">Hapus</button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("hapus-btn")) {
            let disposalId = event.target.getAttribute("data-id");

            let csrfToken = '<?= csrf_token() ?>';
            let csrfHash = '<?= csrf_hash() ?>';

            Swal.fire({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus permohonan penghapusan aset ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`<?= base_url('admin/asset_disposal/delete/') ?>${disposalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": csrfHash
                        },
                        body: JSON.stringify({ csrf_token: csrfHash })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Terhapus!", "Permohonan berhasil dihapus.", "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Gagal!", data.error || "Terjadi kesalahan.", "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire("Error!", "Terjadi kesalahan saat menghapus permohonan.", "error");
                        });
                }
            });
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(".approve-btn").click(function () {
            let disposalId = $(this).data("id");

            Swal.fire({
                title: "Konfirmasi Persetujuan",
                text: "Apakah Anda yakin ingin menyetujui permohonan ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Setujui",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= base_url('admin/asset_disposal/approve/') ?>" + disposalId, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                        },
                        body: JSON.stringify({ csrf_token: "<?= csrf_hash() ?>" })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Berhasil!", "Permohonan disetujui dan aset telah dihapus.", "success")
                                    .then(() => location.reload());
                            } else {
                                Swal.fire("Gagal!", data.error || "Aset masih digunakan atau dalam pemeliharaan.", "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire("Error!", "Terjadi kesalahan saat memproses permohonan.", "error");
                        });
                }
            });
        });
    });

    // Tolak permohonan
    $(".reject-btn").click(function () {
        let disposalId = $(this).data("id");

        Swal.fire({
            title: "Konfirmasi Penolakan",
            text: "Apakah Anda yakin ingin menolak permohonan ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, Tolak",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/asset_disposal/reject/') ?>" + disposalId;
            }
        });
    });




    $(document).ready(function () {
        $(".detail-btn").click(function () {
            let disposalId = $(this).data("id");

            $.ajax({
                url: "<?= base_url('admin/asset_disposal/getDetail/') ?>" + disposalId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        let disposal = data.disposal;

                        let statusBadge = `<span class="badge bg-${disposal.status === 'Disetujui' ? 'success' : (disposal.status === 'Ditolak' ? 'danger' : 'warning')}">${disposal.status}</span>`;

                        let dokumenLink = disposal.dokumen_pendukung
                            ? `<a href="<?= base_url('uploads/dokumen_disposal/') ?>${disposal.dokumen_pendukung}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-file-alt"></i> ${disposal.dokumen_pendukung}
                           </a>`
                            : '<span class="text-danger">Tidak Ada Dokumen</span>';

                        let htmlContent = `
                        <div class="table-responsive">
                            <table class="table table-bordered text-start">
                                <tr>
                                    <th>Kode Barang</th>
                                    <td>${disposal.kode_barang}</td>
                                </tr>
                                <tr>
                                    <th>NUP</th>
                                    <td>${disposal.nup || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Nama Aset</th>
                                    <td>${disposal.nama_barang}</td>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <td>${disposal.merk || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Alasan</th>
                                    <td>${disposal.alasan}</td>
                                </tr>
                                <tr>
                                    <th>Nilai Residu</th>
                                    <td><strong>Rp ${parseFloat(disposal.nilai_residu).toLocaleString('id-ID')}</strong></td>
                                </tr>
                                <tr>
                                    <th>Metode</th>
                                    <td>${disposal.metode}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>${statusBadge}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>${new Date(disposal.created_at).toLocaleDateString('id-ID')}</td>
                                </tr>
                                <tr>
                                    <th>Dokumen Pendukung</th>
                                    <td>${dokumenLink}</td>
                                </tr>
                            </table>
                        </div>
                    `;

                        Swal.fire({
                            title: "Detail Permohonan Aset",
                            html: htmlContent,
                            icon: "info",
                            width: "50%",
                            showCloseButton: true
                        });
                    } else {
                        Swal.fire("Error!", "Gagal mengambil detail aset.", "error");
                    }
                }
            });
        });
    });



</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let userRoles = userRole.toLowerCase().split(",");

        let allowedRoles = ["ipds", "pimpinan"];

        if (!userRoles.some(role => allowedRoles.includes(role.trim()))) {
            $(document).on("click", ".ubah-status-btn, .edit-btn, .hapus-btn, .btn-create-disposal, .btn-create-maintenance", function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                Swal.fire("Akses Ditolak!", "Hanya iPDS dan Pimpinan yang dapat menyetujui, menolak, atau membuat disposal, penggunaan, dan pemeliharaan aset.", "error");
            });
        }
    });


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let userRoles = userRole.toLowerCase().split(",");

        if (!userRoles.includes("pimpinan")) {
            $(document).on("click", ".approve-btn, .hapus-btn, .reject-btn", function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                Swal.fire("Akses Ditolak!", "Hanya Pimpinan yang dapat Menyetujui dan menolak.", "error");
            });
        }
    });

</script>

<?= $this->endSection(); ?>