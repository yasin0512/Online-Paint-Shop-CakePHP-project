<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?> | Online Paint Shop</title>
    <link rel="stylesheet" href="<?= $this->Url->css('style') ?>">
</head>
<body>

<nav class="navbar">
    <div class="navbar-brand">
        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'home']) ?>">
            🎨 Paint Shop
        </a>
    </div>
    <ul class="navbar-menu">
        <li><a href="<?= $this->Url->build(['controller' => 'Paints', 'action' => 'index']) ?>">Products</a></li>
        <?php if ($this->request->getAttribute('identity')): ?>
            <li><a href="<?= $this->Url->build(['controller' => 'Carts', 'action' => 'index']) ?>">🛒 Cart</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'index']) ?>">My Orders</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'logout']) ?>">Logout</a></li>
        <?php else: ?>
            <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'login']) ?>">Login</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'register']) ?>">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<main class="container">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> Online Paint Shop — 淡江大學資訊工程學系 112 學年度專題</p>
</footer>

<script src="<?= $this->Url->js('app') ?>"></script>
</body>
</html>
