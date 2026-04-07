<?php $this->assign('title', 'My Orders'); ?>

<h1>My Orders</h1>

<?php if ($orders->isEmpty()): ?>
    <p>You have no orders yet. <a href="<?= $this->Url->build(['controller' => 'Paints', 'action' => 'index']) ?>">Start shopping!</a></p>
<?php else: ?>
<table class="table">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Items</th>
            <th>Total</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?= h($order->id) ?></td>
            <td><?= $order->date->format('Y-m-d') ?></td>
            <td><?= count($order->orders_paints) ?> item(s)</td>
            <td>NT$ <?= number_format($order->total, 0) ?></td>
            <td><span class="badge badge-info"><?= ucfirst($order->status) ?></span></td>
            <td><a href="<?= $this->Url->build(['action' => 'view', $order->id]) ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
