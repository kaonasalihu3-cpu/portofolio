<?php
declare(strict_types=1);

$user = current_user();
?>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="<?= e(app_url('index.php')); ?>"><?= e(APP_NAME); ?></a>

        <nav class="main-nav" aria-label="Primary">
            <a class="<?= e(active_nav('index.php')); ?>" href="<?= e(app_url('index.php')); ?>">Home</a>
            <a class="<?= e(active_nav('about.php')); ?>" href="<?= e(app_url('about.php')); ?>">About</a>
            <a class="<?= e(active_nav('products.php')); ?>" href="<?= e(app_url('products.php')); ?>">Products</a>
            <a class="<?= e(active_nav('news.php')); ?>" href="<?= e(app_url('news.php')); ?>">News</a>
            <a class="<?= e(active_nav('contact.php')); ?>" href="<?= e(app_url('contact.php')); ?>">Contact</a>
            <?php if ($user === null): ?>
                <a class="<?= e(active_nav('login.php')); ?>" href="<?= e(app_url('login.php')); ?>">Login</a>
                <a class="<?= e(active_nav('register.php')); ?>" href="<?= e(app_url('register.php')); ?>">Register</a>
            <?php else: ?>
                <?php if (is_admin()): ?>
                    <a class="<?= e(active_nav('dashboard.php')); ?>" href="<?= e(app_url('admin/dashboard.php')); ?>">Dashboard</a>
                <?php endif; ?>
                <a href="<?= e(app_url('logout.php')); ?>">Logout</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
