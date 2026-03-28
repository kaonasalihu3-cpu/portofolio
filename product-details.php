<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$slug = trim((string) ($_GET['slug'] ?? ''));
if ($slug === '') {
    redirect('products.php');
}

$pdo = Database::getInstance()->getConnection();
$productModel = new Product($pdo);
$product = $productModel->findBySlug($slug);

if (!$product) {
    Session::flash('error', 'Product not found.');
    redirect('products.php');
}

$pageTitle = $product['title'] . ' | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container details-layout">
        <div>
            <img class="details-image" src="<?= e(app_url($product['image'] ?: 'assets/images/product-default.svg')); ?>" alt="<?= e($product['title']); ?>">
        </div>
        <div>
            <span class="kicker">Product Details</span>
            <h1><?= e($product['title']); ?></h1>
            <p class="lead"><?= e($product['short_description']); ?></p>
            <p><?= nl2br(e($product['body'])); ?></p>
            <?php if (!empty($product['pdf_file'])): ?>
                <a class="btn" href="<?= e(app_url($product['pdf_file'])); ?>" target="_blank" rel="noopener">Open PDF</a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
