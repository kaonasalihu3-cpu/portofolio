<?php
declare(strict_types=1);

if (!defined('APP_NAME')) {
    require_once dirname(__DIR__) . '/config/config.php';
}

$pageTitle = $pageTitle ?? APP_NAME;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kaona Salihu portfolio and dynamic full-stack website.">
    <title><?= e($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(app_url('css/style.css')); ?>">
    <link rel="stylesheet" href="<?= e(app_url('css/auth.css')); ?>">
    <link rel="stylesheet" href="<?= e(app_url('css/admin.css')); ?>">
</head>
<body>
<div class="site-shell">
<?php
$navbarFile = __DIR__ . '/navbar.php';
if (file_exists($navbarFile)) {
    require $navbarFile;
}
?>
<main class="site-main">
