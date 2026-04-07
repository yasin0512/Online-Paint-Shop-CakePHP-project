<?php $this->assign('title', h($paint->name)); ?>

<div class="product-detail">
    <div class="product-swatch-large" style="background-color: <?= h($paint->color_code) ?>"></div>

    <div class="product-info">
        <h1><?= h($paint->name) ?></h1>
        <p class="color-code">Color Code: <strong><?= h($paint->color_code) ?></strong></p>
        <p class="type">Type: <?= h($paint->type) ?></p>
        <p class="description"><?= h($paint->description) ?></p>
        <p class="price">NT$ <?= number_format($paint->price, 0) ?> / can</p>

        <div class="stock-info">
            <?php if ($totalStock === 0): ?>
                <p class="badge badge-danger">⚠️ Out of Stock — please check back later.</p>
            <?php elseif ($totalStock < 17): ?>
                <p class="badge badge-warning">⚠️ Low Stock: only <?= $totalStock ?> can(s) remaining.</p>
            <?php else: ?>
                <p class="badge badge-success">✅ In Stock (<?= $totalStock ?> available)</p>
            <?php endif; ?>
        </div>

        <?php if ($totalStock > 0 && $this->request->getAttribute('identity')): ?>
        <form method="post" action="<?= $this->Url->build(['controller' => 'Carts', 'action' => 'add', $paint->id]) ?>">
            <?= $this->Form->hidden('_Token') ?>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity"
                   value="1" min="1" max="<?= $totalStock ?>" class="qty-input">
            <button type="submit" class="btn btn-primary">🛒 Add to Cart</button>
        </form>
        <?php elseif (!$this->request->getAttribute('identity')): ?>
            <p><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'login']) ?>">Login</a> to purchase.</p>
        <?php endif; ?>

        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-secondary">← Back to Products</a>
    </div>
</div>
