<?php $this->assign('title', 'Home'); ?>

<section class="hero">
    <h1>🎨 Welcome to Online Paint Shop</h1>
    <p>Find the perfect color for your home or office — delivered to your door.</p>
    <a href="<?= $this->Url->build(['controller' => 'Paints', 'action' => 'index']) ?>" class="btn btn-primary">
        Browse Paints
    </a>
</section>

<section class="featured">
    <h2>Featured Products</h2>
    <div class="paint-grid">
        <?php foreach ($featuredPaints as $paint): ?>
        <div class="paint-card">
            <div class="paint-swatch" style="background-color: <?= h($paint->color_code) ?>"></div>
            <div class="paint-info">
                <h3><?= h($paint->name) ?></h3>
                <p class="color-code"><?= h($paint->color_code) ?></p>
                <p class="price">NT$ <?= number_format($paint->price, 0) ?></p>
                <a href="<?= $this->Url->build(['controller' => 'Paints', 'action' => 'view', $paint->id]) ?>"
                   class="btn btn-secondary">View Details</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
