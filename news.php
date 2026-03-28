<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$pdo = Database::getInstance()->getConnection();
$newsModel = new News($pdo);
$posts = $newsModel->getAll();

$pageTitle = 'News | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h1>News & Updates</h1>
            <p class="muted">Latest platform and project announcements.</p>
        </div>
        <div class="card-grid">
            <?php foreach ($posts as $item): ?>
                <article class="card">
                    <img src="<?= e(app_url($item['image'] ?: 'assets/images/news-default.svg')); ?>" alt="<?= e($item['title']); ?>">
                    <div class="card-body">
                        <h2><?= e($item['title']); ?></h2>
                        <p><?= e(mb_substr((string) $item['body'], 0, 140)); ?>...</p>
                        <a class="btn" href="<?= e(app_url('news-details.php?slug=' . urlencode((string) $item['slug']))); ?>">Read More</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <p class="empty-state">No news posts published yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
