<?php $this->assign('title', 'Checkout'); ?>

<h1>Checkout</h1>

<div class="checkout-layout">

    <!-- Order Summary -->
    <div class="order-summary">
        <h2>Order Summary</h2>
        <table class="table">
            <thead>
                <tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td>
                        <span class="swatch-xs" style="background:<?= h($item['paint']->color_code) ?>"></span>
                        <?= h($item['paint']->name) ?>
                    </td>
                    <td><?= h($item['quantity']) ?></td>
                    <td>NT$ <?= number_format($item['subtotal'], 0) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>Subtotal: NT$ <?= number_format($subtotal, 0) ?></p>
        <p>Shipping: NT$ <?= number_format($shipping, 0) ?></p>
        <p class="total"><strong>Total: NT$ <?= number_format($total, 0) ?></strong></p>
    </div>

    <!-- Customer Info & Payment -->
    <div class="checkout-form">
        <h2>Your Information</h2>
        <form method="post" action="<?= $this->Url->build(['action' => 'confirm']) ?>">
            <?= $this->Form->hidden('_Token') ?>

            <div class="form-group">
                <label>Name</label>
                <input type="text" value="<?= h($customer->get('name')) ?>" readonly class="form-control readonly">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" value="<?= h($customer->get('email')) ?>" readonly class="form-control readonly">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" value="<?= h($customer->get('phone')) ?>" readonly class="form-control readonly">
            </div>
            <div class="form-group">
                <label>Delivery Address</label>
                <input type="text" value="<?= h($customer->get('address')) ?>" readonly class="form-control readonly">
            </div>

            <h2>Payment Method</h2>
            <div class="form-group">
                <label>
                    <input type="radio" name="payment_type" value="cash" checked> Cash on Delivery
                </label><br>
                <label>
                    <input type="radio" name="payment_type" value="credit_card"> Credit Card
                </label><br>
                <label>
                    <input type="radio" name="payment_type" value="bank_transfer"> Bank Transfer
                </label>
            </div>
            <div class="form-group" id="acct-field" style="display:none">
                <label>Account / Card Number</label>
                <input type="text" name="acct_no" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx">
            </div>

            <h2>Shipping Type</h2>
            <div class="form-group">
                <label><input type="radio" name="shipment_type" value="standard" checked> Standard (3–5 days)</label><br>
                <label><input type="radio" name="shipment_type" value="express"> Express (1–2 days, +NT$100)</label>
            </div>

            <div class="checkout-warning">
                ⚠️ <strong>Note:</strong> Orders cannot be modified once placed. They can only be returned.
            </div>

            <div class="form-actions">
                <a href="<?= $this->Url->build(['controller' => 'Carts', 'action' => 'index']) ?>" class="btn btn-secondary">
                    ← Back to Cart
                </a>
                <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Confirm order? Orders cannot be modified once placed.')">
                    ✅ Place Order
                </button>
            </div>
        </form>
    </div>

</div>

<script>
document.querySelectorAll('input[name="payment_type"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.getElementById('acct-field').style.display =
            (radio.value !== 'cash') ? 'block' : 'none';
    });
});
</script>
