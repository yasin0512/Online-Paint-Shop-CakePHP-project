<?php $this->assign('title', 'Order #' . $order->id); ?>

<h1>Order #<?= h($order->id) ?></h1>

<div class="order-detail">
    <div class="order-meta">
        <p><strong>Date:</strong> <?= $order->date->format('Y-m-d H:i') ?></p>
        <p><strong>Status:</strong> <span class="badge badge-<?= $order->status === 'delivered' ? 'success' : 'info' ?>">
            <?= ucfirst($order->status) ?>
        </span></p>
        <p><strong>Total:</strong> NT$ <?= number_format($order->total, 0) ?></p>
    </div>

    <h2>Items</h2>
    <table class="table">
        <thead><tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr></thead>
        <tbody>
        <?php foreach ($order->orders_paints as $line): ?>
            <tr>
                <td><?= h($line->paint->name) ?></td>
                <td><?= h($line->quantity) ?></td>
                <td>NT$ <?= number_format($line->subtotal, 0) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!empty($order->payments)): ?>
    <h2>Payment</h2>
    <?php foreach ($order->payments as $p): ?>
        <p>Method: <?= ucfirst(str_replace('_', ' ', $p->type)) ?> |
           Amount: NT$ <?= number_format($p->amount, 0) ?></p>
    <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($order->shipments)): ?>
    <h2>Shipment</h2>
    <?php foreach ($order->shipments as $s): ?>
        <p>Type: <?= ucfirst($s->type) ?> | Tracking #: <?= h($s->seq_num) ?></p>
    <?php endforeach; ?>
    <?php endif; ?>

    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-secondary">← My Orders</a>
</div>
