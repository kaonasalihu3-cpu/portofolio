<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$pdo = Database::getInstance()->getConnection();
$newsModel = new News($pdo);
$items = $newsModel->getAll();

$pageTitle = 'Manage News | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
$success = flash_message('success');
$error = flash_message('error');
?>
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h1>News</h1>
            <a class="btn btn-primary" href="<?= e(app_url('admin/create-news.php')); ?>">Create News</a>
        </div>
        <?php if ($success): ?><div class="alert success"><?= e($success); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert error"><?= e($error); ?></div><?php endif; ?>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= e($item['title']); ?></td>
                        <td><?= e($item['slug']); ?></td>
                        <td><?= e((string) ($item['updated_by_name'] ?? '-')); ?></td>
                        <td>
                            <a class="btn" href="<?= e(app_url('admin/edit-news.php?id=' . (int) $item['id'])); ?>">Edit</a>
                            <form class="inline-form" method="post" action="<?= e(app_url('admin/delete-news.php')); ?>">
                                <?= csrf_input(); ?>
                                <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
