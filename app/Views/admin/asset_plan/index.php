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




<body>
    <div class="container-fluid my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <h2 class="mb-0">Daftar Perencanaan Aset</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <a href="/admin/asset-plan/create" class="btn btn-primary  btn-create-plan">Buat Rencana
                                Baru</a>
                            <a id="exportLink" class="btn btn-success text-right" href="#">
                                <i class="fas fa-file-excel"></i> Export ke Excel
                            </a>
                        </div>


                        <div class="row mb-3">
                            <div class="col-sm-8">
                                <form id="filterForm" class="form-inline">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                    <div class="form-group" style="margin-right: 3px; margin-bottom: 0px;">
                                        <input type="text" id="search" name="search" class="form-control"
                                            placeholder="Cari Nama Aset...">
                                    </div>

                                    <div class="form-group" style="margin-right: 3px; margin-bottom: 0px;">
                                        <select class="form-control" id="month" name="month">
                                            <option value="">Pilih Bulan</option>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                    <div class="form-group" style="margin-right: 3px; margin-bottom: 0px;">
                                        <select class="form-control" id="year" name="year">
                                            <option value="">Pilih Tahun</option>
                                            <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary"
                                        style="margin-right: 3px; margin-bottom: 0px;">Filter</button>
                                    <button class="btn btn-secondary" type="button" id="unfilterBtn"
                                        class="btn btn-default" style="margin-bottom: 0px;">Reset</button>
                                </form>
                            </div>

                            <!-- Total Anggaran -->
                            <div class="col-sm-4 text-right">
                                <p class="mb-0"><strong>Total Anggaran: Rp. <span
                                            id="totalAnggaran"><?= number_format($totalAnggaran, 0, ',', '.') ?></span></strong>
                                </p>
                            </div>
                        </div>





                        <!-- Tabel Data -->
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover"
                                id="dataTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Aset</th>
                                        <th>Merk Aset</th>
                                        <th>Estimasi Biaya</th>
                                        <th>Vendor</th>
                                        <th>Risiko</th>
                                        <th>DeskripsiRisiko</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk memuat data
    $(document).ready(function () {
        function loadData(search = '', month = '', year = '') {
            $.ajax({
                url: "<?= base_url('admin/asset-plan/getData') ?>",
                type: "GET",
                data: { search: search, month: month, year: year },
                dataType: "json",
                success: function (response) {
                    let tableRows = '';
                    let totalAnggaran = response.totalAnggaran || 0;
                    let bulanIndo = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                    if (response.success && response.data.length > 0) {
                        $.each(response.data, function (index, plan) {
                            let date = new Date(plan.created_at);
                            let bulan = bulanIndo[date.getMonth()];
                            let formattedDate = date.getDate() + ' ' + bulan + ' ' + date.getFullYear();

                            let badgeClass = plan.status === 'Approved' ? 'bg-success' :
                                plan.status === 'Pending Approval' ? 'bg-warning' : 'bg-secondary';

                            tableRows += `
                        <tr data-id="${plan.id}">
                            <td>${index + 1}</td>
                            <td>${formattedDate}</td>
                            <td>${plan.nama_aset}</td>
                            <td>${plan.merk}</td>
                            <td>Rp ${parseFloat(plan.estimasi_biaya).toLocaleString('id-ID')}</td>
                            <td>${plan.vendor}</td>
                            <td>${plan.kategori_risiko}</td>
                            <td>${plan.deskripsi_risiko}</td>
                            <td><span class="badge ${badgeClass}">${plan.status}</span></td>
                            <td>
                                <button class="btn btn-sm btn-info update-status" data-id="${plan.id}" data-status="${plan.status}">
                                    Ubah Status
                                </button>
                                <a href="/admin/asset-plan/edit/${plan.id}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="/admin/asset-plan/delete/${plan.id}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>`;
                        });
                    } else {
                        tableRows = '<tr><td colspan="10" class="text-center">Tidak ada data ditemukan.</td></tr>';
                    }

                    $("#dataBody").html(tableRows);
                    $("#totalAnggaran").text(`Rp.${parseFloat(totalAnggaran).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`);
                },
                error: function (xhr, status, error) {
                    console.error("Error AJAX:", error);
                    $("#dataBody").html('<tr><td colspan="10" class="text-danger">Gagal memuat data. Silakan coba lagi.</td></tr>');
                }
            });
        }

        // 🔹 **Search otomatis tanpa tombol filter**
        $("#search").on("input", function () {
            let search = $(this).val();
            let month = $("#month").val();
            let year = $("#year").val();
            loadData(search, month, year);
        });

        // 🔹 **Update total anggaran saat filter diubah**
        $("#filterForm").on("change", "select", function () {
            let search = $("#search").val();
            let month = $("#month").val();
            let year = $("#year").val();
            loadData(search, month, year);
        });

        // 🔹 **Tombol Unfilter untuk reset filter**
        $("#unfilterBtn").click(function () {
            $("#search").val('');
            $("#month").val('');
            $("#year").val('');
            loadData();
        });

        // 🔹 **Load data pertama kali saat halaman dibuka**
        loadData();




        $(document).on("click", ".update-status", function () {
            let id = $(this).data("id");
            let currentStatus = $(this).data("status");

            // Periksa apakah pengguna memiliki izin (gantilah `userRole` sesuai dengan sistem autentikasi kamu)
            let userRole = $("meta[name='user-role']").attr("content"); // Pastikan di `<head>` ada meta tag ini

            if (userRole !== "pimpinan" && userRole !== "superadmin") {
                Swal.fire("Akses Ditolak!", "Anda tidak memiliki izin untuk menyetujui aset.", "error");
                return;
            }

            Swal.fire({
                title: "Ubah Status Aset",
                text: "Pilih status baru untuk aset ini:",
                icon: "question",
                showCancelButton: true,
                showDenyButton: true,
                showConfirmButton: true,
                confirmButtonText: "Approved",
                denyButtonText: "Pending Approval",
                cancelButtonText: "Draft",
                confirmButtonColor: "#28a745",
                denyButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d"
            }).then((result) => {
                let newStatus = null;
                if (result.isConfirmed) newStatus = "Approved";
                else if (result.isDenied) newStatus = "Pending Approval";
                else if (result.dismiss === Swal.DismissReason.cancel) newStatus = "Draft";

                if (newStatus && newStatus !== currentStatus) {
                    let csrfToken = $("meta[name='csrf-token']").attr("content");

                    $.ajax({
                        url: `/admin/asset-plan/updateStatus/${id}`,
                        type: "POST",
                        contentType: "application/json",
                        headers: { "X-CSRF-TOKEN": csrfToken },
                        data: JSON.stringify({ status: newStatus }),
                        success: function (data) {
                            if (data.success) {
                                Swal.fire("Berhasil!", "Status telah diperbarui.", "success");

                                // 🔹 **Perbarui token CSRF agar request berikutnya tidak "Forbidden"**
                                if (data.csrfToken) {
                                    $("meta[name='csrf-token']").attr("content", data.csrfToken);
                                }

                                loadData(); // Refresh tabel tanpa reload halaman
                            } else {
                                Swal.fire("Gagal!", data.error, "error");
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 403) {
                                Swal.fire("Akses Ditolak!", "Anda tidak memiliki izin untuk menyetujui aset.", "error");
                            } else {
                                Swal.fire("Error!", "Terjadi kesalahan.", "error");
                            }
                        }
                    });

                }
            });
        });

    });




</script>
<!-- 
<script>
    $(document).on("click", ".update-status", function () {
        let id = $(this).data("id");
        let currentStatus = $(this).data("status");

        Swal.fire({
            title: "Ubah Status Aset",
            text: "Pilih status baru untuk aset ini:",
            icon: "question",
            showCancelButton: true,
            showDenyButton: true,
            showConfirmButton: true,
            confirmButtonText: "Approved",
            denyButtonText: "Pending Approval",
            cancelButtonText: "Draft",
            confirmButtonColor: "#28a745",
            denyButtonColor: "#ffc107",
            cancelButtonColor: "#6c757d"
        }).then((result) => {
            let newStatus = null;
            if (result.isConfirmed) newStatus = "Approved";
            else if (result.isDenied) newStatus = "Pending Approval";
            else if (result.dismiss === Swal.DismissReason.cancel) newStatus = "Draft";

            if (newStatus && newStatus !== currentStatus) {
                let csrfToken = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: `/admin/asset-plan/updateStatus/${id}`,
                    type: "POST",
                    contentType: "application/json",
                    headers: { "X-CSRF-TOKEN": csrfToken },
                    data: JSON.stringify({ status: newStatus }),
                    success: function (data) {
                        if (data.success) {
                            Swal.fire("Berhasil!", "Status telah diperbarui.", "success");
                            if (data.csrfToken) {
                                $("meta[name='csrf-token']").attr("content", data.csrfToken);
                            }
                            loadData();
                        } else {
                            Swal.fire("Gagal!", data.error, "error");
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 403) {
                            Swal.fire("Akses Ditolak!", "Anda tidak memiliki izin untuk menyetujui aset.", "error");
                        } else {
                            Swal.fire("Error!", "Terjadi kesalahan.", "error");
                        }
                    }
                });

            }
        });
    });

</script> -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let userRoles = userRole.split(",");

        if (!userRoles.includes("Tata Usaha")) {
            $(".btn-create-plan, .btn-create-acquisition").click(function (event) {
                event.preventDefault();
                Swal.fire("Akses Ditolak!", "Hanya Tata Usaha yang dapat menambahkan perencanaan aset.", "error");
            });
        }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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

                let url = "<?= base_url('admin/asset-plan/export'); ?>";
                const params = new URLSearchParams();

                if (search) params.append('search', search);
                if (month) params.append('month', month);
                if (year) params.append('year', year);

                exportLink.href = `${url}?${params.toString()}`;
            }

            updateExportLink(); // Inisialisasi awal
        } else {
            console.error("Element filter atau exportLink tidak ditemukan.");
        }
    });
</script>




<?= $this->endSection(); ?>