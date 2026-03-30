<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . app_url($path));
    exit;
}

function current_user(): ?array
{
    return Auth::user();
}

function is_admin(): bool
{
    return Auth::isAdmin();
}

function active_nav(string $page): string
{
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $page ? 'active' : '';
}

function request_method(): string
{
    return strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
}

function is_post(): bool
{
    return request_method() === 'POST';
}

function old_input(string $key, string $default = ''): string
{
    return e((string) ($_POST[$key] ?? $default));
}

function flash_message(string $key): ?string
{
    return Session::flash($key);
}

function csrf_token(): string
{
    $token = Session::get('_csrf_token');
    if (!is_string($token) || $token === '') {
        $token = bin2hex(random_bytes(32));
        Session::set('_csrf_token', $token);
    }
    return $token;
}

function csrf_input(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(?string $token): bool
{
    $stored = Session::get('_csrf_token');
    return is_string($stored) && is_string($token) && hash_equals($stored, $token);
}
