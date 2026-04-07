<?php $this->assign('title', 'Admin – All Orders'); ?>

<h1>🛠️ Staff Panel — All Orders</h1>

<table class="table">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?= h($order->id) ?></td>
            <td><?= h($order->customer->name) ?></td>
            <td><?= $order->date->format('Y-m-d H:i') ?></td>
            <td>NT$ <?= number_format($order->total, 0) ?></td>
            <td><span class="badge badge-info"><?= ucfirst($order->status) ?></span></td>
            <td>
                <form method="post" action="<?= $this->Url->build(['action' => 'updateStatus', $order->id]) ?>">
                    <?= $this->Form->hidden('_Token') ?>
                    <select name="status" class="form-control-sm">
                        <?php foreach (['pending','inspecting','shipped','delivered','returned'] as $s): ?>
                            <option value="<?= $s ?>" <?= $order->status === $s ? 'selected' : '' ?>>
                                <?= ucfirst($s) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
