<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$pdo = Database::getInstance()->getConnection();
$siteContentModel = new SiteContent($pdo);
$productModel = new Product($pdo);
$newsModel = new News($pdo);

$hero = $siteContentModel->getSection('home', 'hero');
$aboutPreview = $siteContentModel->getSection('home', 'about_preview');
$cta = $siteContentModel->getSection('home', 'cta');
$featuredProducts = $productModel->getFeatured(3);
$latestNews = $newsModel->getLatest(3);

$pageTitle = 'Home | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero-section">
    <div class="container hero-grid">
        <div>
            <span class="kicker">Welcome</span>
            <h1><?= e($hero['title'] ?? APP_NAME); ?></h1>
            <p><?= e($hero['body'] ?? 'Professional portfolio and full-stack project platform.'); ?></p>
            <a class="btn btn-primary" href="<?= e(app_url('contact.php')); ?>">Contact Me</a>
        </div>
        <div class="hero-image-wrap">
            <img src="<?= e(app_url($hero['image'] ?? 'assets/images/kaona-profile.jpg')); ?>" alt="<?= e(APP_NAME); ?> profile" class="hero-image">
        </div>
    </div>
</section>

<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h2>Featured Products</h2>
            <a href="<?= e(app_url('products.php')); ?>" class="text-link">View all</a>
        </div>
        <div class="card-grid">
            <?php foreach ($featuredProducts as $item): ?>
                <article class="card">
                    <img src="<?= e(app_url($item['image'] ?: 'assets/images/product-default.svg')); ?>" alt="<?= e($item['title']); ?>">
                    <div class="card-body">
                        <h3><?= e($item['title']); ?></h3>
                        <p><?= e($item['short_description']); ?></p>
                        <a class="btn" href="<?= e(app_url('product-details.php?slug=' . urlencode((string) $item['slug']))); ?>">View Details</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if (empty($featuredProducts)): ?>
                <p class="empty-state">No products available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section-block section-soft">
    <div class="container">
        <div class="section-head">
            <h2>Latest News</h2>
            <a href="<?= e(app_url('news.php')); ?>" class="text-link">Read all</a>
        </div>
        <div class="card-grid">
            <?php foreach ($latestNews as $item): ?>
                <article class="card">
                    <img src="<?= e(app_url($item['image'] ?: 'assets/images/news-default.svg')); ?>" alt="<?= e($item['title']); ?>">
                    <div class="card-body">
                        <h3><?= e($item['title']); ?></h3>
                        <p><?= e(mb_substr((string) $item['body'], 0, 120)); ?>...</p>
                        <a class="btn" href="<?= e(app_url('news-details.php?slug=' . urlencode((string) $item['slug']))); ?>">Read More</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if (empty($latestNews)): ?>
                <p class="empty-state">No news posts yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section-block">
    <div class="container cta-box">
        <h2><?= e($aboutPreview['title'] ?? 'About Preview'); ?></h2>
        <p><?= e($aboutPreview['body'] ?? 'Learn more about skills, education, and project direction.'); ?></p>
        <div class="cta-actions">
            <a class="btn" href="<?= e(app_url('about.php')); ?>">About Me</a>
            <a class="btn btn-primary" href="<?= e(app_url('contact.php')); ?>"><?= e($cta['title'] ?? 'Start a Project'); ?></a>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
