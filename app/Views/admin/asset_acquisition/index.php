<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<?php
use Myth\Auth\Authorization\GroupModel;

$groupModel = new GroupModel();
$userGroups = $groupModel->getGroupsForUser(user_id());
$userGroupNames = array_column($userGroups, 'name');

$userRole = !empty($userGroupNames) ? implode(',', $userGroupNames) : 'user';
?>
<meta name="user-role" content="<?= esc($userRole); ?>">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-4">Daftar Pengajuan Akuisisi Aset</h2>

            </div>

            <form id="filterForm" class="mb-3 d-flex gap-2">
                <input type="text" style="margin-right: 3px; margin-bottom: 10px" id="search" class="form-control w-25"
                    placeholder="Cari nama aset...">

                <select style="margin-right: 3px; margin-bottom: 10px" id="month" class="form-control w-25">
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

                <select style="margin-right: 3px; margin-bottom: 10px" id="year" class="form-control w-25">
                    <option value="">Pilih Tahun</option>
                    <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <button type="button" style="margin-right: 3px; margin-bottom: 20px" id="applyFilter"
                    class="btn btn-primary">Filter</button>
                <button type="button" style="margin-right: 3px; margin-bottom: 20px" id="resetFilter"
                    class="btn btn-secondary">Reset</button>

                <a href="<?= base_url('admin/asset_acquisition/create') ?>"
                    style="margin-left: 150px; margin-bottom: 10px" class="btn btn-primary  btn-create-plan">
                    <i class="fas fa-plus"></i> Buat Pengajuan Baru
                </a>
            </form>

            <div class="alert alert-info">
                <strong>Total Biaya: </strong> Rp <span id="totalBiaya">0</span>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Aset</th>
                                    <th>Merk Aset</th>
                                    <th>Estimasi Biaya</th>
                                    <th>Vendor</th>
                                    <th>Tanggal Dibuat</th>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        function loadData(search = '', month = '', year = '') {
            $.ajax({
                url: "<?= base_url('admin/asset_acquisition/loadData') ?>",
                type: "GET",
                data: { search: search, month: month, year: year },
                dataType: "json",
                success: function (response) {
                    let tableRows = '';
                    let totalBiaya = 0;

                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function (index, acquisition) {
                            let badgeClass = acquisition.status === 'Disetujui' ? 'bg-success' :
                                acquisition.status === 'Ditolak' ? 'bg-danger' : 'bg-warning';
                            let date = new Date(acquisition.created_at);
                            let bulanIndo = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                            let tanggalDibuat = date.getDate() + ' ' + bulanIndo[date.getMonth()] + ' ' + date.getFullYear();

                            totalBiaya += parseFloat(acquisition.estimasi_biaya);

                            tableRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${acquisition.nama_aset}</td>
                            <td>${acquisition.merk}</td>
                            <td>Rp ${parseFloat(acquisition.estimasi_biaya).toLocaleString('id-ID', { minimumFractionDigits: 0 })}</td>
                            <td>${acquisition.vendor}</td>
                            <td>${tanggalDibuat}</td>
                            <td><span class="badge ${badgeClass}">${acquisition.status}</span></td>
                            <td>
                                <button class="btn btn-success btn-sm approve-btn" data-id="${acquisition.id}">Setujui</button>
                                <button class="btn btn-danger btn-sm reject-btn" data-id="${acquisition.id}">Tolak</button>
                            </td>
                        </tr>
                    `;
                        });
                    } else {
                        tableRows = '<tr><td colspan="9">Tidak ada data yang ditemukan.</td></tr>';
                    }

                    $("#totalBiaya").text(totalBiaya.toLocaleString('id-ID', { minimumFractionDigits: 0 }));

                    $("#dataBody").html(tableRows);
                },
                error: function (xhr, status, error) {
                    console.error("Error AJAX:", error);
                    $("#dataBody").html('<tr><td colspan="9" class="text-danger">Gagal memuat data. Silakan coba lagi.</td></tr>');
                }
            });
        }

        loadData();

        $("#search").on("keyup", function () {
            let search = $(this).val().trim();
            loadData(search);
        });

        $("#applyFilter").click(function () {
            let search = $("#search").val().trim();
            let month = $("#month").val();
            let year = $("#year").val();
            loadData(search, month, year);
        });

        $("#resetFilter").click(function () {
            $("#search").val('');
            $("#month").val('');
            $("#year").val('');
            loadData();
        });
    });

</script>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let allowedRoles = ["pimpinan", "superadmin"];
        let userRoles = userRole.split(",");

        let hasPermission = userRoles.some(role => allowedRoles.includes(role.trim()));

        if (!hasPermission) {
            $(".approve-btn, .reject-btn").prop("disabled", true);
        }

        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("approve-btn") || event.target.classList.contains("reject-btn")) {

                if (!hasPermission) {
                    Swal.fire("Akses Ditolak!", "Anda tidak memiliki izin untuk menyetujui atau menolak aset.", "error");
                    event.stopImmediatePropagation();
                    return;
                }

                let assetId = event.target.getAttribute("data-id");

                if (event.target.classList.contains("approve-btn")) {
                    Swal.fire({
                        title: "Konfirmasi Persetujuan",
                        text: "Apakah Anda yakin ingin menyetujui akuisisi aset ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Setujui!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?= base_url('approve/'); ?>" + assetId;
                        }
                    });
                }

                if (event.target.classList.contains("reject-btn")) {
                    Swal.fire({
                        title: "Konfirmasi Penolakan",
                        text: "Apakah Anda yakin ingin menolak akuisisi aset ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, Tolak!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?= base_url('reject/'); ?>" + assetId;
                        }
                    });
                }
            }
        }, true);
    });


</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userRole = $("meta[name='user-role']").attr("content") || "";
        let userRoles = userRole.split(",");

        if (!userRoles.includes("Tata Usaha")) {
            $(".btn-create-plan, .btn-create-acquisition").click(function (event) {
                event.preventDefault();
                Swal.fire("Akses Ditolak!", "Hanya Tata Usaha yang dapat menambahkan perencanaan dan akuisisi aset.", "error");
            });
        }
    });

</script>

<?= $this->endSection(); ?>