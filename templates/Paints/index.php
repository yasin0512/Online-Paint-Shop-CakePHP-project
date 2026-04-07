<?php $this->assign('title', 'All Paints'); ?>

<h1>Our Paint Collection</h1>

<div class="paint-grid">
<?php foreach ($paints as $paint):
    $totalStock = array_sum(array_column($paint->paints_storages, 'quantity'));
?>
    <div class="paint-card <?= $totalStock === 0 ? 'out-of-stock' : '' ?>">
        <div class="paint-swatch" style="background-color: <?= h($paint->color_code) ?>"></div>
        <div class="paint-info">
            <h3><?= h($paint->name) ?></h3>
            <p class="color-code"><?= h($paint->color_code) ?> &bull; <?= h($paint->color) ?></p>
            <p class="type"><?= h($paint->type) ?> paint</p>
            <p class="price">NT$ <?= number_format($paint->price, 0) ?></p>
            <?php if ($totalStock === 0): ?>
                <span class="badge badge-danger">Out of Stock</span>
            <?php elseif ($totalStock < 17): ?>
                <span class="badge badge-warning">Low Stock (<?= $totalStock ?> left)</span>
            <?php else: ?>
                <span class="badge badge-success">In Stock (<?= $totalStock ?>)</span>
            <?php endif; ?>
            <a href="<?= $this->Url->build(['action' => 'view', $paint->id]) ?>"
               class="btn btn-secondary">View Details</a>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?= $this->element('paging') ?>
