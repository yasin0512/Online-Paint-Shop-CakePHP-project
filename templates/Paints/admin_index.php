<?php $this->assign('title', 'Admin – Manage Paints'); ?>

<h1>🎨 Admin — Manage Paints</h1>

<table class="table">
    <thead>
        <tr>
            <th>Swatch</th>
            <th>Name</th>
            <th>Code</th>
            <th>Type</th>
            <th>Price</th>
            <th>Total Stock</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($paints as $paint):
        $totalStock = array_sum(array_column($paint->paints_storages, 'quantity'));
    ?>
        <tr>
            <td><div class="swatch-sm" style="background:<?= h($paint->color_code) ?>"></div></td>
            <td><?= h($paint->name) ?></td>
            <td><?= h($paint->color_code) ?></td>
            <td><?= h($paint->type) ?></td>
            <td>NT$ <?= number_format($paint->price, 0) ?></td>
            <td>
                <?php if ($totalStock < 17): ?>
                    <span class="badge badge-warning"><?= $totalStock ?> ⚠️</span>
                <?php else: ?>
                    <span class="badge badge-success"><?= $totalStock ?></span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
