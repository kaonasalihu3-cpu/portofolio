<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$errors = [];
$form = [
    'title' => '',
    'short_description' => '',
    'body' => '',
    'image' => '',
    'pdf_file' => '',
];

if (is_post()) {
    $form = [
        'title' => trim((string) ($_POST['title'] ?? '')),
        'short_description' => trim((string) ($_POST['short_description'] ?? '')),
        'body' => trim((string) ($_POST['body'] ?? '')),
        'image' => trim((string) ($_POST['image'] ?? '')),
        'pdf_file' => trim((string) ($_POST['pdf_file'] ?? '')),
    ];

    $errors = Validator::validateContent($form, true);
    if (empty($errors)) {
        $pdo = Database::getInstance()->getConnection();
        $productModel = new Product($pdo);
        $user = current_user();
        $saved = $productModel->create($form, (int) $user['id']);
        if ($saved) {
            Session::flash('success', 'Product created successfully.');
            redirect('admin/products.php');
        }
        $errors['general'] = 'Could not create product.';
    }
}

$pageTitle = 'Create Product | ' . APP_NAME;
require_once dirname(__DIR__) . '/includes/header.php';
?>
<section class="section-block">
    <div class="container form-wrap">
        <h1>Create Product</h1>
        <?php if (!empty($errors['general'])): ?><div class="alert error"><?= e($errors['general']); ?></div><?php endif; ?>
        <form method="post" novalidate>
            <label>Title</label>
            <input name="title" value="<?= e($form['title']); ?>">
            <small class="error-text"><?= e($errors['title'] ?? ''); ?></small>

            <label>Short Description</label>
            <textarea name="short_description" rows="3"><?= e($form['short_description']); ?></textarea>
            <small class="error-text"><?= e($errors['short_description'] ?? ''); ?></small>

            <label>Body</label>
            <textarea name="body" rows="6"><?= e($form['body']); ?></textarea>
            <small class="error-text"><?= e($errors['body'] ?? ''); ?></small>

            <label>Image Path</label>
            <input name="image" value="<?= e($form['image']); ?>">

            <label>PDF Path</label>
            <input name="pdf_file" value="<?= e($form['pdf_file']); ?>">

            <button class="btn btn-primary" type="submit">Save Product</button>
        </form>
    </div>
</section>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
