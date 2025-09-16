<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<meta name="csrf_token" content="<?= csrf_hash(); ?>" />

<div class="container- my-2 mx-4">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    List Pengaduan Aset <br />
                    <div class="btn-actions-pane-right">
                        <div class="col-md-3 md-9 text-right">
                            <a id="exportLink" href="<?= base_url('PostController/export'); ?>"
                                download="List-Pengaduan-Aset.xlsx" class="btn btn-success"><i
                                    class="fa-regular fa-file-excel"></i> Export to Excel</a>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <div class="btn-actions-pane-left">
                        <div class="row mt-3">
                            <div class="col-lg-25 text-center">
                                <form action="<?= base_url('PostController/searchAdmin') ?>" method="post">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                    <div class="form-group input-holder">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_query"
                                                name="search_query" placeholder="Cari Data Disini"
                                                value="<?= isset($search_query) ? esc($search_query) : '' ?>" required>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>


                    <div class="btn-actions-pane-right">
                        <div class="row mr-0 mt-3">
                            <form action="<?= base_url('PostController/filterAdmin') ?>" method="post"
                                class="form-inline">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                <div class="form-group mr-2">
                                    <label for="start_date" class="mr-2">Dari: </label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : '' ?>" required>
                                </div>
                                <div class="form-group mr-2">
                                    <label for="end_date" class="mr-2">Sampai: </label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?= isset($_POST['end_date']) ? $_POST['end_date'] : '' ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                    </div>






                </div>





                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Nomor Aset</th>
                                <th class="text-center">Jenis Aset</th>
                                <th class="text-center">NUP Aset</th>
                                <th class="text-center">Merk Aset</th>
                                <th class="text-center">Kondisi Aset</th>
                                <th class="text-center">Deskripsi Kerusakan</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Tanggal Pembuatan Laporan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal Selesai Laporan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($laporan as $lapor): ?>
                                <tr>
                                    <!-- Data Laporan -->
                                    <td class="text-center"><?= $lapor['nama']; ?></td>
                                    <td class="text-center"><?= $lapor['nomor_aset']; ?></td>
                                    <td class="text-center"><?= $lapor['jenis_aset']; ?></td>
                                    <td class="text-center"><?= $lapor['NUP']; ?></td>
                                    <td class="text-center"><?= $lapor['merk']; ?></td>
                                    <td class="text-center"><?= $lapor['kondisi_aset']; ?></td>
                                    <td class="text-center"><?= $lapor['deskripsi']; ?></td>
                                    <td class="text-center"><?= $lapor['lokasi']; ?></td>
                                    <td class="text-center"><?= $lapor['created_at']; ?></td>
                                    <td class="text-center">
                                        <div
                                            class="badge apu <?= ($lapor['status'] == 'Dalam Proses') ? 'badge-warning' : 'badge-success'; ?>">
                                            <?= $lapor['status']; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?= ($lapor['status'] == 'Selesai') ? $lapor['tanggal_selesai'] : 'Laporan belum selesai'; ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="mr-2 btn-icon btn-icon-only btn btn-info"
                                            href="<?= base_url('admin/edit/' . $lapor['id']); ?>"
                                            id="btnEdit<?= $lapor['id']; ?>">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>

                                        <?php if ($lapor['status'] == 'Dalam Proses'): ?>
                                            <a href="<?= site_url('PostController/selesaikanLaporan/' . $lapor['id']); ?>"
                                                class="mr-2 btn-icon btn-icon-only btn btn-success"
                                                id="btnSelesai<?= $lapor['id']; ?>">Selesai</a>
                                        <?php endif; ?>
                                        <a class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                                            href="<?= route_to('delete_laporan', $lapor['id']); ?>"
                                            id="btnHapus<?= $lapor['id']; ?>">
                                            <i class="pe-7s-trash btn-icon-wrapper"></i>Hapus
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-block text-center card-footer">
                    <a href="<?= base_url('admin/list'); ?>"
                        class="mr-2 btn-icon btn-icon-only btn btn-outline-primary">Tampilkan Semua?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert Konfirmasi Penghapusan dan Penyelesaian -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php foreach ($laporan as $lapor): ?>
            // SweetAlert untuk Hapus Laporan
            document.getElementById('btnHapus<?= $lapor['id']; ?>').addEventListener('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "Apakah Anda yakin ingin menghapus laporan ini?",
                    text: "Anda tidak akan bisa mengembalikannya lagi!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Iya, Saya Yakin",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Pengalihan dengan SweetAlert kedua
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Laporan anda telah terhapus",
                            icon: "success",
                            willClose: () => {
                                // Setelah animasi selesai, lakukan pengalihan
                                window.location.href = e.target.getAttribute('href');
                            }
                        });
                    }
                });
            });

            // SweetAlert untuk Selesaikan Laporan
            <?php if ($lapor['status'] == 'Dalam Proses'): ?>
                document.getElementById('btnSelesai<?= $lapor['id']; ?>').addEventListener('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Apakah Anda yakin ingin menyelesaikan laporan ini?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Selesaikan",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Terselesaikan!",
                                text: "Laporan Anda Telah Diselesaikan.",
                                icon: "success",
                                willClose: () => {
                                    // Setelah animasi selesai, lakukan pengalihan
                                    window.location.href = e.target.getAttribute('href');
                                }
                            });
                        }
                    });
                });
            <?php endif; ?>
        <?php endforeach; ?>
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const exportLink = document.getElementById('exportLink');
        const searchQueryInput = document.getElementById('search_query');

        if (startDateInput && endDateInput && exportLink) {
            startDateInput.addEventListener('change', updateExportLink);
            endDateInput.addEventListener('change', updateExportLink);
            searchQueryInput.addEventListener('input', updateExportLink);

            function updateExportLink() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const searchQuery = searchQueryInput.value;

                let url = "<?= base_url('PostController/export'); ?>";
                const params = new URLSearchParams();
                if (startDate && endDate) {
                    params.append('start_date', startDate);
                    params.append('end_date', endDate);
                }
                if (searchQuery) {
                    params.append('search_query', searchQuery);
                }

                exportLink.href = `${url}?${params.toString()}`;
                console.log("Export URL: ", exportLink.href); // Debugging
            }

            updateExportLink();
        } else {
            console.error("Start Date or End Date input or export link not found.");
        }
    });
</script>

<?= $this->endSection(); ?>