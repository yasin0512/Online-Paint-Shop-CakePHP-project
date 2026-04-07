<?php $this->assign('title', 'Login'); ?>

<div class="auth-box">
    <h1>Login</h1>
    <form method="post" action="<?= $this->Url->build(['action' => 'login']) ?>">
        <?= $this->Form->hidden('_Token') ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <p>No account? <a href="<?= $this->Url->build(['action' => 'register']) ?>">Register here</a></p>
    </form>
</div>
