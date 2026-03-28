<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$slug = trim((string) ($_GET['slug'] ?? ''));
if ($slug === '') {
    redirect('news.php');
}

$pdo = Database::getInstance()->getConnection();
$newsModel = new News($pdo);
$post = $newsModel->findBySlug($slug);

if (!$post) {
    Session::flash('error', 'News post not found.');
    redirect('news.php');
}

$pageTitle = $post['title'] . ' | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container details-layout">
        <div>
            <img class="details-image" src="<?= e(app_url($post['image'] ?: 'assets/images/news-default.svg')); ?>" alt="<?= e($post['title']); ?>">
        </div>
        <div>
            <span class="kicker">News Details</span>
            <h1><?= e($post['title']); ?></h1>
            <p><?= nl2br(e($post['body'])); ?></p>
            <?php if (!empty($post['pdf_file'])): ?>
                <a class="btn" href="<?= e(app_url($post['pdf_file'])); ?>" target="_blank" rel="noopener">Open PDF</a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
