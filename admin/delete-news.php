<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id > 0) {
    $pdo = Database::getInstance()->getConnection();
    $newsModel = new News($pdo);
    $newsModel->delete($id);
}

redirect('admin/news.php');
