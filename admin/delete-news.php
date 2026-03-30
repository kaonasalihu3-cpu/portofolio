<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

if (!is_post() || !verify_csrf($_POST['_csrf'] ?? null)) {
    redirect('admin/news.php');
}

$id = (int) ($_POST['id'] ?? 0);
if ($id > 0) {
    $pdo = Database::getInstance()->getConnection();
    $newsModel = new News($pdo);
    $newsModel->delete($id);
}

redirect('admin/news.php');
