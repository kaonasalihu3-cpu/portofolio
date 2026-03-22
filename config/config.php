<?php
declare(strict_types=1);

/**
 * Runtime environment controls.
 * APP_ENV: development|production (default: development)
 * APP_DEBUG: 1|0 (optional override)
 */
$env = strtolower((string) (getenv('APP_ENV') ?: 'development'));
if (!in_array($env, ['development', 'production'], true)) {
    $env = 'development';
}
define('APP_ENV', $env);

$debugOverride = getenv('APP_DEBUG');
if ($debugOverride !== false) {
    $debug = in_array(strtolower((string) $debugOverride), ['1', 'true', 'yes', 'on'], true);
} else {
    $debug = APP_ENV !== 'production';
}
define('APP_DEBUG', $debug);

error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('display_startup_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
date_default_timezone_set('Europe/Warsaw');

define('APP_NAME', 'KAONA SALIHU');
define('BASE_URL', '/kaona-salihu-project');
define('ROOT_PATH', dirname(__DIR__));

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'kaona_salihu_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('UPLOAD_DIR', 'assets/uploads/');
define('UPLOAD_ABS_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR);

spl_autoload_register(static function (string $class): void {
    $file = ROOT_PATH . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

Session::start();
