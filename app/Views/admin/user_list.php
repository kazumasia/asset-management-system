<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<h1 class="h4 text-gray-900 mb-4"></h1>
<div class="container- my-2 mx-4 justify-content-center">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Daftar <?= $title ?>

                </div>

                <div class="card-header">
                    <div class="btn-actions-pane-left">
                        <div class="row mt-3">
                            <div class="col-lg-25 text-center">
                                <form action="<?= base_url('Users/searchUsers') ?>" method="post">
                                    <?= csrf_field() ?>

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
                        <div class="col-md-3 md-9 text-right">
                            <a id="exportLink" href="<?= base_url('users/add'); ?>" class="btn btn-primary"><i
                                    class="fa-solid fa-plus"></i> Buat Akun Baru?</a>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Grup</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Aktif</th>
                                <th class="text-center" style="width: 90px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="text-center"><?= $user->id; ?></td>
                                    <td class="text-center"><?= $user->username; ?></td>
                                    <td class="text-center"><?= !empty($user->group_name) ? $user->group_name : 'N/A'; ?>
                                    </td>
                                    <td class="text-center"><?= $user->email; ?></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-circle btn-active-users"
                                            data-id="<?= $user->id; ?>" data-active="<?= $user->active == 1 ? 1 : 0; ?>"
                                            title="Klik untuk Mengaktifkan atau Menonaktifkan">
                                            <?= $user->active == 1 ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'; ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>/users/changePassword/<?= $user->id; ?>"
                                            class="btn btn-warning btn-circle btn-sm" title="Ubah Password">
                                            <i class="fas fa-key"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>



                <div class="d-block text-center card-footer">
                    <a href="<?= base_url('users'); ?>"
                        class="mr-2 btn-icon btn-icon-only btn btn-outline-primary">Tampilkan Semua?</a>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.btn-active-users').on('click', function () {
            const id = $(this).data('id');
            const active = $(this).data('active');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Status pengguna akan diubah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url(); ?>/users/activate',
                        type: 'POST',
                        data: {
                            id: id,
                            active: (active == 1 ? 0 : 1),
                            csrf_token_name: '<?= csrf_token() ?>',
                            ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                        },
                        success: function (response) {
                            Swal.fire(
                                'Berhasil!',
                                'Status pengguna telah diperbarui.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire(
                                'Gagal!',
                                'Ada kesalahan saat memperbarui status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>


<?= $this->endSection(); ?>