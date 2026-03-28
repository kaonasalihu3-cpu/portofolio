<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$errors = [];
$form = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => '',
];

if (is_post()) {
    $form = [
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'subject' => trim((string) ($_POST['subject'] ?? '')),
        'message' => trim((string) ($_POST['message'] ?? '')),
    ];

    $errors = Validator::validateContact($form);

    if (empty($errors)) {
        $pdo = Database::getInstance()->getConnection();
        $messageModel = new ContactMessage($pdo);
        $saved = $messageModel->create($form);

        if ($saved) {
            Session::flash('success', 'Your message has been sent successfully.');
            redirect('contact.php');
        }

        $errors['general'] = 'Message could not be saved. Please try again.';
    }
}

$pageTitle = 'Contact | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
$success = flash_message('success');
?>
<section class="section-block">
    <div class="container form-wrap">
        <h1>Contact Us</h1>
        <p class="muted">Send a message and we will respond as soon as possible.</p>

        <?php if ($success): ?>
            <div class="alert success"><?= e($success); ?></div>
        <?php endif; ?>
        <?php if (!empty($errors['general'])): ?>
            <div class="alert error"><?= e($errors['general']); ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="<?= e($form['name']); ?>">
            <small class="error-text"><?= e($errors['name'] ?? ''); ?></small>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e($form['email']); ?>">
            <small class="error-text"><?= e($errors['email'] ?? ''); ?></small>

            <label for="subject">Subject</label>
            <input id="subject" name="subject" type="text" value="<?= e($form['subject']); ?>">
            <small class="error-text"><?= e($errors['subject'] ?? ''); ?></small>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="6"><?= e($form['message']); ?></textarea>
            <small class="error-text"><?= e($errors['message'] ?? ''); ?></small>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
