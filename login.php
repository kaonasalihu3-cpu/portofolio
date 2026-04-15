<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

if (Auth::check()) {
    redirect('index.php');
}

$errors = [];
$email = '';

if (is_post()) {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    $pdo = Database::getInstance()->getConnection();
    $userModel = new User($pdo);
    $auth = new Auth($userModel);

    if ($auth->login($email, $password, $errors)) {
        Session::flash('success', 'Welcome back.');
        redirect('index.php');
    }
}

$pageTitle = 'Login | ' . APP_NAME;
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-block">
    <div class="container form-wrap auth-box">
        <h1>Login</h1>
        <?php if (!empty($errors['general'])): ?>
            <div class="alert error"><?= e($errors['general']); ?></div>
        <?php endif; ?>
        <form id="login-form" method="post" novalidate>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e($email); ?>">
            <small class="error-text"><?= e($errors['email'] ?? ''); ?></small>

            <label for="password">Password</label>
            <input id="password" name="password" type="password">
            <small class="error-text"><?= e($errors['password'] ?? ''); ?></small>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
