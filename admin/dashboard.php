<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$pdo = Database::getInstance()->getConnection();
$userModel = new User($pdo);
$productModel = new Product($pdo);
$newsModel = new News($pdo);
$messageModel = new ContactMessage($pdo);

$stats = [
    'users' => $userModel->countAll(),
    'products' => $productModel->countAll(),
    'news' => $newsModel->countAll(),
    'messages' => $messageModel->countAll(),
];

$pageTitle = 'Admin Dashboard | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
?>
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h1>Admin Dashboard</h1>
            <p class="muted">Overview of core platform data.</p>
        </div>

        <div class="admin-stats">
            <article class="admin-card">
                <h2>Total Users</h2>
                <p><?= e((string) $stats['users']); ?></p>
            </article>
            <article class="admin-card">
                <h2>Total Products</h2>
                <p><?= e((string) $stats['products']); ?></p>
            </article>
            <article class="admin-card">
                <h2>Total News</h2>
                <p><?= e((string) $stats['news']); ?></p>
            </article>
            <article class="admin-card">
                <h2>Total Messages</h2>
                <p><?= e((string) $stats['messages']); ?></p>
            </article>
        </div>

        <div class="admin-actions">
            <a class="btn" href="<?= e(app_url('admin/users.php')); ?>">Manage Users</a>
            <a class="btn" href="<?= e(app_url('admin/products.php')); ?>">Manage Products</a>
            <a class="btn" href="<?= e(app_url('admin/news.php')); ?>">Manage News</a>
            <a class="btn" href="<?= e(app_url('admin/messages.php')); ?>">View Messages</a>
            <a class="btn" href="<?= e(app_url('admin/content.php')); ?>">Manage Content</a>
        </div>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
