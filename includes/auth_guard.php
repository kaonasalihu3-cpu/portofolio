<?php
declare(strict_types=1);

if (!defined('APP_NAME')) {
    require_once dirname(__DIR__) . '/config/config.php';
}

if (!Auth::check()) {
    Session::flash('error', 'Please log in to continue.');
    redirect('login.php');
}
