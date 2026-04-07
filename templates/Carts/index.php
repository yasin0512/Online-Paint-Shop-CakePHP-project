<?php $this->assign('title', 'Shopping Cart'); ?>

<h1>🛒 Your Shopping Cart</h1>

<?php if (empty($cartItems)): ?>
    <p>Your cart is empty. <a href="<?= $this->Url->build(['controller' => 'Paints', 'action' => 'index']) ?>">Browse paints</a></p>
<?php else: ?>

<table class="table">
    <thead>
        <tr>
            <th>Color</th>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($cartItems as $item): ?>
        <tr>
            <td><div class="swatch-sm" style="background:<?= h($item['paint']->color_code) ?>"></div></td>
            <td><?= h($item['paint']->name) ?></td>
            <td>NT$ <?= number_format($item['paint']->price, 0) ?></td>
            <td><?= h($item['quantity']) ?></td>
            <td>NT$ <?= number_format($item['subtotal'], 0) ?></td>
            <td>
                <form method="post" action="<?= $this->Url->build(['action' => 'remove', $item['paint']->id]) ?>">
                    <?= $this->Form->hidden('_Token') ?>
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="cart-summary">
    <p>Subtotal: <strong>NT$ <?= number_format($subtotal, 0) ?></strong></p>
    <p>Shipping: <strong>NT$ <?= number_format($shipping, 0) ?></strong></p>
    <p class="total">Total: <strong>NT$ <?= number_format($total, 0) ?></strong></p>
</div>

<div class="cart-actions">
    <form method="post" action="<?= $this->Url->build(['action' => 'clear']) ?>" style="display:inline">
        <?= $this->Form->hidden('_Token') ?>
        <button type="submit" class="btn btn-secondary" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
    </form>
    <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'checkout']) ?>" class="btn btn-primary">
        Proceed to Checkout →
    </a>
</div>

<?php endif; ?>
