<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>


<div class="container">
    <h2>Edit Pengguna</h2>
    <form action="<?= site_url('admin/manajemenpengguna/update/' . $user->id) ?>" method="post">
        <?= csrf_field() ?>


        <input type="hidden" name="id" value="<?= esc($user->id) ?>">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= esc($user->email) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= esc($user->username) ?>"
                placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"
                placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Pengguna</button>
    </form>
</div>


<?= $this->endSection(); ?>