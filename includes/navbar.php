<?php
declare(strict_types=1);

$user = current_user();
?>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="<?= e(app_url('index.php')); ?>"><?= e(APP_NAME); ?></a>
        <button id="nav-toggle" class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">Menu</button>

        <nav id="primary-nav" class="main-nav" aria-label="Primary">
            <a class="<?= e(active_nav('index.php')); ?>" aria-current="<?= active_nav('index.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('index.php')); ?>">Home</a>
            <a class="<?= e(active_nav('about.php')); ?>" aria-current="<?= active_nav('about.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('about.php')); ?>">About</a>
            <a class="<?= e(active_nav('products.php')); ?>" aria-current="<?= active_nav('products.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('products.php')); ?>">Products</a>
            <a class="<?= e(active_nav('news.php')); ?>" aria-current="<?= active_nav('news.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('news.php')); ?>">News</a>
            <a class="<?= e(active_nav('contact.php')); ?>" aria-current="<?= active_nav('contact.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('contact.php')); ?>">Contact</a>
            <?php if ($user === null): ?>
                <a class="<?= e(active_nav('login.php')); ?>" aria-current="<?= active_nav('login.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('login.php')); ?>">Login</a>
                <a class="<?= e(active_nav('register.php')); ?>" aria-current="<?= active_nav('register.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('register.php')); ?>">Register</a>
            <?php else: ?>
                <?php if (is_admin()): ?>
                    <a class="<?= e(active_nav('dashboard.php')); ?>" aria-current="<?= active_nav('dashboard.php') ? 'page' : 'false'; ?>" href="<?= e(app_url('admin/dashboard.php')); ?>">Dashboard</a>
                    <a href="<?= e(app_url('admin/logout.php')); ?>">Logout</a>
                <?php else: ?>
                    <a href="<?= e(app_url('logout.php')); ?>">Logout</a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>
</header>
