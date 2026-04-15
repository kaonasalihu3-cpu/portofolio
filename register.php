<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

if (Auth::check()) {
    redirect('index.php');
}

$errors = [];
$form = [
    'full_name' => '',
    'email' => '',
];

if (is_post()) {
    $form = [
        'full_name' => trim((string) ($_POST['full_name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
    ];

    $data = [
        'full_name' => $form['full_name'],
        'email' => $form['email'],
        'password' => (string) ($_POST['password'] ?? ''),
        'confirm_password' => (string) ($_POST['confirm_password'] ?? ''),
    ];

    $pdo = Database::getInstance()->getConnection();
    $userModel = new User($pdo);
    $auth = new Auth($userModel);

    if ($auth->register($data, $errors)) {
        Session::flash('success', 'Registration completed. You can now log in.');
        redirect('login.php');
    }
}

$pageTitle = 'Register | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container form-wrap auth-box">
        <h1>Register</h1>
        <form id="register-form" method="post" novalidate>
            <label for="full_name">Full Name</label>
            <input id="full_name" name="full_name" type="text" value="<?= e($form['full_name']); ?>">
            <small class="error-text"><?= e($errors['full_name'] ?? ''); ?></small>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e($form['email']); ?>">
            <small class="error-text"><?= e($errors['email'] ?? ''); ?></small>

            <label for="password">Password</label>
            <input id="password" name="password" type="password">
            <small class="error-text"><?= e($errors['password'] ?? ''); ?></small>

            <label for="confirm_password">Confirm Password</label>
            <input id="confirm_password" name="confirm_password" type="password">
            <small class="error-text"><?= e($errors['confirm_password'] ?? ''); ?></small>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
