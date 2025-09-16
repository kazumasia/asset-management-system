<tbody>
    <?php foreach ($laporan as $lapor): ?>
        <tr>
            <td class="text-center"><?= $lapor['nama']; ?></td>
            <td class="text-center"><?= $lapor['nomor_aset']; ?></td>
            <td class="text-center"><?= $lapor['jenis_aset']; ?></td>
            <td class="text-center"><?= $lapor['deskripsi']; ?></td>
            <td class="text-center"><?= $lapor['lokasi']; ?></td>
            <td class="text-center"><?= $lapor['created_at']; ?></td>
            <td class="text-center">
                <div class="badge <?= ($lapor['status'] == 'Dalam Proses') ? 'badge-warning' : 'badge-success'; ?>">
                    <?= $lapor['status']; ?>
                </div>
            </td>
            <td class="text-center"><?= ($lapor['status'] == 'Selesai') ? $lapor['tanggal_selesai'] : 'Belum Selesai'; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?= $pager->links(); ?>
    </ul>
</nav>