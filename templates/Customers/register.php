<?php $this->assign('title', 'Register'); ?>

<div class="auth-box">
    <h1>Create Account</h1>
    <form method="post" action="<?= $this->Url->build(['action' => 'register']) ?>">
        <?= $this->Form->hidden('_Token') ?>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required value="<?= h($customer->name ?? '') ?>">
            <?php if ($customer->hasErrors()): ?>
                <span class="error"><?= $customer->getError('name')[0] ?? '' ?></span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?= h($customer->email ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="0912-345-678">
        </div>
        <div class="form-group">
            <label>Delivery Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <p>Already have an account? <a href="<?= $this->Url->build(['action' => 'login']) ?>">Login</a></p>
    </form>
</div>
