<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$products = [];
$loadError = null;
try {
    $pdo = Database::getInstance()->getConnection();
    $productModel = new Product($pdo);
    $products = $productModel->getAll();
} catch (Throwable $e) {
    $loadError = 'Products are temporarily unavailable.';
}

$pageTitle = 'Products | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h1>Products & Portfolio</h1>
            <p class="muted">Explore practical projects and product ideas.</p>
        </div>
        <?php if ($loadError): ?><div class="alert error"><?= e($loadError); ?></div><?php endif; ?>

        <div class="card-grid">
            <?php foreach ($products as $item): ?>
                <article class="card">
                    <img src="<?= e(app_url($item['image'] ?: 'assets/images/product-default.svg')); ?>" alt="<?= e($item['title']); ?>">
                    <div class="card-body">
                        <h2><?= e($item['title']); ?></h2>
                        <p><?= e($item['short_description']); ?></p>
                        <a class="btn" href="<?= e(app_url('product-details.php?slug=' . urlencode((string) $item['slug']))); ?>">View Details</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if (empty($products)): ?>
                <p class="empty-state">No products published yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
