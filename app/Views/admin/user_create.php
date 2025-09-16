<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container- my-2 mx-4">
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

                <div class="table-responsive">
                    <form action="<?= site_url('admin/manajemenpengguna/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>

                <div class="d-block text-center card-footer">
                    <a href="<?= base_url('admin/list'); ?>"
                        class="mr-2 btn-icon btn-icon-only btn btn-outline-primary">Tampilkan Semua?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h2>Tambah Pengguna</h2>
    <form action="<?= site_url('admin/manajemenpengguna/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>


<?= $this->endSection(); ?>