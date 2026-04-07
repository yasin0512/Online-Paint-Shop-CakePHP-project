<?php $this->assign('title', 'Warehouse Inventory'); ?>

<h1>📦 Warehouse Inventory</h1>

<?php if (!$lowStock->isEmpty()): ?>
<div class="alert alert-warning">
    ⚠️ <strong>Low Stock Alert!</strong> The following paints are below the threshold (<?= $lowStockThreshold ?> cans):
    <ul>
        <?php foreach ($lowStock as $r): ?>
            <li><?= h($r->paint->name) ?> — only <strong><?= $r->quantity ?></strong> can(s) left</li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>Color</th>
            <th>Paint</th>
            <th>Type</th>
            <th>Storage Location</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Restock</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($records as $r): ?>
        <tr class="<?= $r->quantity < $lowStockThreshold ? 'row-warning' : '' ?>">
            <td><div class="swatch-sm" style="background:<?= h($r->paint->color_code) ?>"></div></td>
            <td><?= h($r->paint->name) ?></td>
            <td><?= h($r->paint->type) ?></td>
            <td><?= h($r->storage->location) ?></td>
            <td><?= h($r->quantity) ?></td>
            <td>
                <?php if ($r->quantity === 0): ?>
                    <span class="badge badge-danger">Out of Stock</span>
                <?php elseif ($r->quantity < $lowStockThreshold): ?>
                    <span class="badge badge-warning">⚠️ Low Stock</span>
                <?php else: ?>
                    <span class="badge badge-success">OK</span>
                <?php endif; ?>
            </td>
            <td>
                <form method="post" action="<?= $this->Url->build(['action' => 'restock']) ?>">
                    <?= $this->Form->hidden('_Token') ?>
                    <input type="hidden" name="paint_id"   value="<?= $r->paint_id ?>">
                    <input type="hidden" name="storage_id" value="<?= $r->storage_id ?>">
                    <input type="number" name="quantity" value="50" min="1" class="qty-input-sm">
                    <button type="submit" class="btn btn-primary btn-sm">+ Restock</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
