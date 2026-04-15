<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$id = (int) ($_GET['id'] ?? 0);
$pdo = Database::getInstance()->getConnection();

$stmt = $pdo->prepare('SELECT * FROM site_content WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();

if (!$row) {
    redirect('admin/content.php');
}

$errors = [];
$form = $row;

if (is_post()) {
    $form = [
        'page_key' => trim((string) ($_POST['page_key'] ?? '')),
        'section_key' => trim((string) ($_POST['section_key'] ?? '')),
        'title' => trim((string) ($_POST['title'] ?? '')),
        'body' => trim((string) ($_POST['body'] ?? '')),
        'image' => trim((string) ($_POST['image'] ?? '')),
    ];

    if ($form['page_key'] === '') {
        $errors['page_key'] = 'Page key is required.';
    }
    if ($form['section_key'] === '') {
        $errors['section_key'] = 'Section key is required.';
    }
    if ($form['title'] === '') {
        $errors['title'] = 'Title is required.';
    }
    if ($form['body'] === '') {
        $errors['body'] = 'Body is required.';
    }

    if (empty($errors)) {
        $contentModel = new SiteContent($pdo);
        $user = current_user();
        $saved = $contentModel->upsert($form, (int) $user['id']);
        if ($saved) {
            Session::flash('success', 'Content section updated successfully.');
            redirect('admin/content.php');
        }
        $errors['general'] = 'Unable to update section.';
    }
}

$pageTitle = 'Edit Site Content | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
?>
<section class="section-block">
    <div class="container form-wrap">
        <h1>Edit Site Content</h1>
        <?php if (!empty($errors['general'])): ?><div class="alert error"><?= e($errors['general']); ?></div><?php endif; ?>
        <form id="admin-content-edit-form" method="post" novalidate>
            <label>Page Key</label>
            <input name="page_key" value="<?= e((string) $form['page_key']); ?>">
            <small class="error-text"><?= e($errors['page_key'] ?? ''); ?></small>

            <label>Section Key</label>
            <input name="section_key" value="<?= e((string) $form['section_key']); ?>">
            <small class="error-text"><?= e($errors['section_key'] ?? ''); ?></small>

            <label>Title</label>
            <input name="title" value="<?= e((string) $form['title']); ?>">
            <small class="error-text"><?= e($errors['title'] ?? ''); ?></small>

            <label>Body</label>
            <textarea name="body" rows="7"><?= e((string) $form['body']); ?></textarea>
            <small class="error-text"><?= e($errors['body'] ?? ''); ?></small>

            <label>Image Path</label>
            <input name="image" value="<?= e((string) ($form['image'] ?? '')); ?>">

            <button class="btn btn-primary" type="submit">Save Changes</button>
        </form>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
