<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$pdo = Database::getInstance()->getConnection();
$messageModel = new ContactMessage($pdo);

$markReadId = (int) ($_GET['read'] ?? 0);
if ($markReadId > 0) {
    $messageModel->markRead($markReadId);
    redirect('admin/messages.php');
}

$messages = $messageModel->getAll();

$pageTitle = 'Contact Messages | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
?>
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <h1>Contact Messages</h1>
            <p class="muted">Review incoming messages from the website.</p>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td><?= e($msg['name']); ?></td>
                        <td><?= e($msg['email']); ?></td>
                        <td><?= e($msg['subject']); ?></td>
                        <td><?= e(mb_substr((string) $msg['message'], 0, 90)); ?></td>
                        <td><?= (int) $msg['is_read'] === 1 ? 'Read' : 'Unread'; ?></td>
                        <td>
                            <?php if ((int) $msg['is_read'] === 0): ?>
                                <a class="btn" href="<?= e(app_url('admin/messages.php?read=' . (int) $msg['id'])); ?>">Mark Read</a>
                            <?php else: ?>
                                <span class="muted">Done</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
