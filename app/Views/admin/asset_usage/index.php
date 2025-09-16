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

<head>
    <meta name="csrf-token" content="<?= csrf_hash(); ?>">
</head>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Daftar Penggunaan Aset</h2>

            <a href="<?= base_url('admin/asset_usage/create') ?>" class="btn btn-primary btn-create-usage mb-3">Tambah
                Penggunaan</a>
            <a id="exportLink" href="#" class="btn btn-success mb-3">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>

            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" id="search" class="form-control"
                            style="margin-right: 5px; margin-bottom: 0px;"
                            placeholder="Cari aset, pegawai, atau tujuan...">
                        <select id="month" class="form-control" style="margin-right: 5px; margin-bottom: 0px;">
                            <option value="">Pilih Bulan</option>
                            <?php
                            $bulan = [
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            ];
                            foreach ($bulan as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="year" class="form-control" style="margin-right: 5px; margin-bottom: 0px;">
                            <option value="">Pilih Tahun</option>
                            <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <button id="applyFilter" class="btn btn-primary"
                            style="margin-right: 5px; margin-bottom: 0px;">Filter</button>
                        <button id="resetFilter" class="btn btn-secondary"
                            style="margin-right: 5px; margin-bottom: 0px;">Reset</button>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>NUP</th>
                                    <th>Nama Aset</th>
                                    <th>Merk</th>
                                    <th>Pegawai</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        function loadData(search = '', month = '', year = '') {
            $.ajax({
                url: "<?= base_url('admin/asset_usage/loadData') ?>",
                type: "GET",
                data: { search: search, month: month, year: year },
                dataType: "json",
                success: function (response) {
                    let tableRows = '';

                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function (index, usage) {
                            let badgeClass = usage.status === 'Dikembalikan' ? 'bg-success' :
                                usage.status === 'Rusak' ? 'bg-danger' : 'bg-warning';
                            let tanggalMulai = new Date(usage.tanggal_mulai).toLocaleDateString('id-ID');

                            let tanggalSelesai = usage.tanggal_selesai && usage.tanggal_selesai !== "0000-00-00"
                                ? new Date(usage.tanggal_selesai).toLocaleDateString('id-ID')
                                : '<span class="text-danger fw-bold">(Belum Dikembalikan)</span>';

                            tableRows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${usage.kode_barang}</td>
                        <td>${usage.nup}</td>
                        <td>${usage.nama_barang}</td>
                        <td>${usage.merk}</td>
                        <td>${usage.pegawai}</td>
                        <td>${usage.tujuan}</td>
                        <td>${tanggalMulai}</td>
                        <td>${tanggalSelesai}</td>
                        <td><span class="badge ${badgeClass}">${usage.status}</span></td>
                        <td>
                            <a href="<?= base_url('admin/asset_usage/ubah/') ?>${usage.id}" class="btn btn-warning btn-sm edit-btn">Edit</a>
                            ${usage.status === 'Digunakan' ? `
                            <button class="btn btn-primary btn-sm selesai-btn" data-id="${usage.id}">Selesaikan</button>` : ''}
                            <button class="btn btn-danger btn-sm hapus-btn" data-id="${usage.id}">Hapus</button>
                        </td>
                    </tr>
                `;
                        });
                    } else {
                        tableRows = '<tr><td colspan="11">Tidak ada data yang ditemukan.</td></tr>';
                    }

                    $("#dataBody").html(tableRows);
                }
            });
        }



        loadData();

        $("#search").on("input", function () {
            loadData($(this).val().trim());
        });

        $("#applyFilter").click(function () {
            loadData($("#search").val().trim(), $("#month").val(), $("#year").val());
        });

        $("#resetFilter").click(function () {
            $("#search").val('');
            $("#month").val('');
            $("#year").val('');
            loadData();
        });

        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("selesai-btn")) {
                let usageId = event.target.getAttribute("data-id");

                Swal.fire({
                    title: "Konfirmasi Selesai",
                    text: "Apakah Anda yakin ingin menyelesaikan penggunaan aset ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Selesaikan!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("<?= base_url('admin/asset_usage/complete/'); ?>" + usageId, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("Berhasil!", "Penggunaan aset telah diselesaikan.", "success");
                                    loadData();
                                    Swal.fire("Gagal!", data.error || "Terjadi kesalahan.", "error");
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                Swal.fire("Error!", "Terjadi kesalahan saat menyelesaikan penggunaan aset.", "error");
                            });
                    }
                });
            }
        });
        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("hapus-btn")) {
                let usageId = event.target.getAttribute("data-id");

                Swal.fire({
                    title: "Konfirmasi Hapus",
                    text: "Apakah Anda yakin ingin menghapus penggunaan aset ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("<?= base_url('admin/asset_usage/delete/') ?>" + usageId, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: new URLSearchParams({ "<?= csrf_token() ?>": "<?= csrf_hash() ?>" })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("Terhapus!", "Data telah dihapus.", "success");
                                    loadData();
                                } else {
                                    Swal.fire("Gagal!", data.error || "Terjadi kesalahan.", "error");
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                            });
                    }
                });
            }
        });
    });
</script>
<script>
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("hapus-btn")) {
            let usageId = event.target.getAttribute("data-id");

            Swal.fire({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus penggunaan aset ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= base_url('admin/asset_usage/delete/') ?>" + usageId, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: new URLSearchParams({ "<?= csrf_token() ?>": "<?= csrf_hash() ?>" })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Terhapus!", "Data telah dihapus.", "success");
                                loadData();
                            } else {
                                Swal.fire("Gagal!", data.error || "Terjadi kesalahan.", "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                        });
                }
            });
        }
    });


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let userRoles = userRole.toLowerCase().split(",");

        if (!userRoles.includes("ipds")) {
            $(document).on("click", ".edit-btn, .selesai-btn, .hapus-btn, .btn-create-disposal, .btn-create-usage, .btn-create-maintenance", function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                Swal.fire("Akses Ditolak!", "Hanya IPDS yang dapat Menambah, Mengedit, Menghapus dan Menyelesaikan Penggunaan Aset.", "error");
            });
        }
    });

</script>

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

                let url = "<?= base_url('admin/asset_usage/export'); ?>";
                const params = new URLSearchParams();

                if (search) params.append('search', search);
                if (month) params.append('month', month);
                if (year) params.append('year', year);

                exportLink.href = `${url}?${params.toString()}`;
            }

            updateExportLink(); // Set awal
        } else {
            console.error("Element filter atau exportLink tidak ditemukan.");
        }
    });
</script>



<?= $this->endSection(); ?>