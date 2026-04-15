<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/admin_guard.php';

if (!is_post() || !verify_csrf($_POST['_csrf'] ?? null)) {
    redirect('admin/products.php');
}

$id = (int) ($_POST['id'] ?? 0);
if ($id > 0) {
    $pdo = Database::getInstance()->getConnection();
    $productModel = new Product($pdo);
    if ($productModel->delete($id)) {
        Session::flash('success', 'Product deleted successfully.');
    } else {
        Session::flash('error', 'Product could not be deleted.');
    }
}

redirect('admin/products.php');
