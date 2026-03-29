<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$pdo = Database::getInstance()->getConnection();
$contentModel = new SiteContent($pdo);
$sections = $contentModel->getAll();

$pageTitle = 'Manage Site Content | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
?>
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h1>Site Content</h1>
            <p class="muted">Edit page sections from database records.</p>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>Section</th>
                        <th>Title</th>
                        <th>Updated By</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($sections as $section): ?>
                    <tr>
                        <td><?= e($section['page_key']); ?></td>
                        <td><?= e($section['section_key']); ?></td>
                        <td><?= e($section['title']); ?></td>
                        <td><?= e((string) ($section['updated_by_name'] ?? '-')); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
