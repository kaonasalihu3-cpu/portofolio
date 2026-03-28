<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$pdo = Database::getInstance()->getConnection();
$siteContentModel = new SiteContent($pdo);

$sections = $siteContentModel->getSectionsByPage('about');
$map = [];
foreach ($sections as $section) {
    $map[$section['section_key']] = $section;
}

$intro = $map['intro'] ?? null;
$mission = $map['mission'] ?? null;
$vision = $map['vision'] ?? null;

$pageTitle = 'About | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container about-grid">
        <div class="about-image-wrap">
            <img src="<?= e(app_url($intro['image'] ?? 'assets/images/kaona-profile.jpg')); ?>" alt="About <?= e(APP_NAME); ?>" class="about-image">
        </div>
        <div>
            <span class="kicker">About</span>
            <h1><?= e($intro['title'] ?? 'Professional Profile'); ?></h1>
            <p><?= nl2br(e($intro['body'] ?? 'Portfolio owner and full-stack student developer.')); ?></p>
        </div>
    </div>
</section>

<section class="section-block section-soft">
    <div class="container card-grid two-col">
        <article class="card">
            <div class="card-body">
                <h2><?= e($mission['title'] ?? 'Mission'); ?></h2>
                <p><?= nl2br(e($mission['body'] ?? 'Build practical and polished digital products.')); ?></p>
            </div>
        </article>
        <article class="card">
            <div class="card-body">
                <h2><?= e($vision['title'] ?? 'Vision'); ?></h2>
                <p><?= nl2br(e($vision['body'] ?? 'Deliver scalable products with clear user experience.')); ?></p>
            </div>
        </article>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
