<?php
declare(strict_types=1);

require_once __DIR__ . '/auth_guard.php';

if (!Auth::isAdmin()) {
    Session::flash('error', 'You do not have permission to access that page.');
    redirect('index.php');
}
