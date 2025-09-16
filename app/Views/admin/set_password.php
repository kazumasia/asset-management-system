<?= $this->extend('templates/admin') ?>
<?= $this->section('page-content') ?>
<?php if (isset($validation)) { ?>
    <div class="col-md-12">
        <?php foreach ($validation->getErrors() as $error): ?>
            <div class="alert alert-warning" role="alert">
                <i class="mdi mdi-alert-outline me-2"></i>
                <?= esc($error) ?>
            </div>
        <?php endforeach ?>
    </div>
<?php } ?>

<div class="d-flex justify-content-center align-items-center mt-4 mb-4">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h5 class="text-center mb-3">Setel Ulang Kata Sandi</h5>
        <form action="<?= base_url(); ?>/users/setPassword" method="post">
            <input type="hidden" name="id" class="id" value="<?= $id; ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <input type="password" name="password"
                    class="form-control <?php if (session('errors.password')): ?>is-invalid<?php endif ?>"
                    placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <input type="password" name="pass_confirm"
                    class="form-control <?php if (session('errors.pass_confirm')): ?>is-invalid<?php endif ?>"
                    placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        </form>
    </div>
</div>


<?= $this->endSection() ?>