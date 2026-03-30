<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$errors = [];
$form = [
    'title' => '',
    'body' => '',
    'image' => '',
    'pdf_file' => '',
];

if (is_post()) {
    $form = [
        'title' => trim((string) ($_POST['title'] ?? '')),
        'body' => trim((string) ($_POST['body'] ?? '')),
        'image' => trim((string) ($_POST['image'] ?? '')),
        'pdf_file' => trim((string) ($_POST['pdf_file'] ?? '')),
    ];

    $errors = Validator::validateContent($form, false);

    $imageError = null;
    $pdfError = null;
    $uploadedImage = FileUpload::uploadImage($_FILES['image_file'] ?? [], $imageError);
    $uploadedPdf = FileUpload::uploadPdf($_FILES['pdf_file_upload'] ?? [], $pdfError);

    if ($imageError !== null) {
        $errors['image_file'] = $imageError;
    } elseif ($uploadedImage !== null) {
        $form['image'] = $uploadedImage;
    }

    if ($pdfError !== null) {
        $errors['pdf_file_upload'] = $pdfError;
    } elseif ($uploadedPdf !== null) {
        $form['pdf_file'] = $uploadedPdf;
    }

    if (empty($errors)) {
        $pdo = Database::getInstance()->getConnection();
        $newsModel = new News($pdo);
        $user = current_user();
        $saved = $newsModel->create($form, (int) $user['id']);
        if ($saved) {
            Session::flash('success', 'News post created successfully.');
            redirect('admin/news.php');
        }
        $errors['general'] = 'Could not create news post.';
    }
}

$pageTitle = 'Create News | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
?>
<section class="section-block">
    <div class="container form-wrap">
        <h1>Create News</h1>
        <?php if (!empty($errors['general'])): ?><div class="alert error"><?= e($errors['general']); ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data" novalidate>
            <label>Title</label>
            <input name="title" value="<?= e($form['title']); ?>">
            <small class="error-text"><?= e($errors['title'] ?? ''); ?></small>

            <label>Body</label>
            <textarea name="body" rows="7"><?= e($form['body']); ?></textarea>
            <small class="error-text"><?= e($errors['body'] ?? ''); ?></small>

            <label>Image Path</label>
            <input name="image" value="<?= e($form['image']); ?>">
            <label>Upload Image</label>
            <input name="image_file" type="file" accept=".jpg,.jpeg,.png,.webp">
            <small class="error-text"><?= e($errors['image_file'] ?? ''); ?></small>

            <label>PDF Path</label>
            <input name="pdf_file" value="<?= e($form['pdf_file']); ?>">
            <label>Upload PDF</label>
            <input name="pdf_file_upload" type="file" accept=".pdf">
            <small class="error-text"><?= e($errors['pdf_file_upload'] ?? ''); ?></small>

            <button class="btn btn-primary" type="submit">Save News</button>
        </form>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
