<tr>
    <td class="text-center"><?= $row->id; ?></td>
    <td class="text-center"><?= $row->username; ?></td>
    <td class="text-center"><?= empty($group) ? '' : $group[0]['name']; ?></td>
    <td class="text-center"><?= $row->email; ?></td>
    <td class="text-center" align="center">
        <a href="#" class="btn btn-sm btn-circle btn-active-users" data-id="<?= $row->id; ?>"
            data-active="<?= $row->active == 1 ? 1 : 0; ?>" title="Klik untuk Mengaktifkan atau Menonaktifkan">
            <?= $row->active == 1 ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'; ?>
        </a>
    </td>
    <td class="text-center" align="center">
        <a href="<?= base_url(); ?>/users/changePassword/<?= $row->id; ?>" class="btn btn-warning btn-circle btn-sm"
            title="Ubah Password">
            <i class="fas fa-key"></i>
        </a>
        <a href="#" class="btn btn-success btn-circle btn-sm btn-change-group" data-id="<?= $row->id; ?>"
            title="Ubah Grup">
            <i class="fas fa-tasks"></i>
        </a>
    </td>
</tr>